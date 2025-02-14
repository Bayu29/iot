<?php

namespace App\Http\Controllers\Admin;

use App\Models\Instance;
use App\Models\Bussiness;
use App\Models\District;
use App\Models\Province;
use App\Models\City;
use App\Models\Village;
use App\Models\OperationalTime;
use App\Models\SettingToleranceAlert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class InstanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:instance_show')->only('index');
        $this->middleware('permission:instance_create')->only('create', 'store');
        $this->middleware('permission:instance_update')->only('edit', 'update');
        $this->middleware('permission:instance_delete')->only('delete');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Instance::with([
                'province',
                'city',
                'district',
                'village',
                'bussiness',
                'subinstance'
            ])
                ->orderBy('id', 'desc')
                ->get();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('province', function ($row) {
                    if ($row->province) {
                        return $row->province->provinsi;
                    }

                    return '-';
                })
                ->addColumn('city', function ($row) {
                    if ($row->city) {
                        return $row->city->kabupaten_kota;
                    }

                    return '-';
                })
                ->addColumn('district', function ($row) {
                    if ($row->district) {
                        return $row->district->kecamatan;
                    }

                    return '-';
                })
                ->addColumn('village', function ($row) {
                    if ($row->village) {
                        return $row->village->kelurahan;
                    }

                    return '-';
                })
                ->addColumn('bussiness', function ($row) {
                    if ($row->bussiness) {
                        return $row->bussiness->bussiness_name;
                    }
                })
                ->addColumn('action', 'admin.instance._action')
                ->toJson();
        }
        return view('admin.instance.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bussinesses = Bussiness::all();
        $provinces = Province::all();
        $instance_code = IdGenerator::generate([
            'table' => 'instances',
            'field' => 'instance_code',
            'length' => 16,
            'prefix' => 'ISC-' . date('Ymd')
        ]);

        return view('admin.instance.create', compact('bussinesses', 'provinces', 'instance_code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'instance_code' => 'required|string|unique:instances,instance_code',
                'instance_name' => 'required|string',
                'push_url' => 'required|string',
                'address1' => 'required|string',
                'address2' => 'required|string',
                'province_id' => 'required|numeric|exists:tbl_provinsi,id',
                'city_id' => 'required|numeric|exists:tbl_kabkot,id',
                'district_id' => 'required|numeric|exists:tbl_kecamatan,id',
                'village_id' => 'required|numeric|exists:tbl_kelurahan,id',
                'zip_code' => 'required|string|exists:tbl_kelurahan,kd_pos',
                'email' => 'required|string|email|unique:instances,email',
                'phone' => 'required|string|regex:/[0-9]+/im|unique:instances,phone',
                'bussiness_id' => 'required|numeric|exists:bussinesses,id',
                'username' => 'required|string|unique:instances,username',
                'password' => [
                    'required', Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
                ],
                'longitude' => 'required|string',
                'latitude' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        try {
            $response = Http::withHeaders(['x-access-token' => setting_web()->token_callback])
                ->withOptions(['verify' => false])
                ->post(setting_web()->endpoint_nms . '/openapi/app/create', [
                    "appName" =>  Str::slug(request('instance_name', '_')),
                    "pushURL" => $request->push_url,
                    "enableMQTT" => false
                ]);

            $data = $request->except(['_token']);
            $data['password'] = Hash::make($data['password']);
            $data['appID'] = $response['appID'];
            $data['appName'] = Str::slug(request('instance_name', '_'));
            $instances = Instance::create($data);


            if ($instances) {
                Alert::toast('Data success saved', 'success');
                return redirect()->route('instance.index');
            } else {
                Alert::toast('Data failed to save', 'error');
                return redirect()->route('instance.index');
            }
        } catch (Exception $e) {
            Alert::toast('Data failed to save', 'error');
            return redirect()->route('instance.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instance  $instance
     * @return \Illuminate\Http\Response
     */
    public function show(Instance $instance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instance  $instance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $instance = Instance::findOrFail($id);
        $provinces = Province::all();
        $bussinesses = Bussiness::all();
        $city = City::where('id', $instance->city_id)->get();
        $village = Village::where('id', $instance->village_id)->get();
        $district = District::where('id', $instance->district_id)->get();

        return view('admin.instance.edit', compact(
            'instance',
            'provinces',
            'bussinesses',
            'city',
            'village',
            'district',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instance  $instance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'instance_code' => 'required|string|unique:instances,instance_code,' . $id,
                'instance_name' => 'required|string',
                'push_url' => 'required|string',
                'address1' => 'required|string',
                'address2' => 'required|string',
                'province_id' => 'required|numeric|exists:tbl_provinsi,id',
                'city_id' => 'required|numeric|exists:tbl_kabkot,id',
                'district_id' => 'required|numeric|exists:tbl_kecamatan,id',
                'village_id' => 'required|numeric|exists:tbl_kelurahan,id',
                'zip_code' => 'required|string|exists:tbl_kelurahan,kd_pos',
                'email' => 'required|string|email|unique:instances,email,' . $id,
                'phone' => 'required|string|regex:/[0-9]+/im|unique:instances,phone,' . $id,
                'bussiness_id' => 'required|numeric|exists:bussinesses,id',
                'username' => 'required|string|unique:instances,username,' . $id,
                'password' => [
                    'nullable', Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()
                ],
                'longitude' => 'required|string',
                'latitude' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            // Alert::toast('Data failed to save. ' . $validator->errors()->first(), 'error');
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        $instance = Instance::findOrFail($id);

        DB::beginTransaction();

        try {
            $data = $request->except('_token');

            if (isset($data['password']) || $request->has('password')) {
                $data['password'] = Hash::make($data['password']);
            }

            $instance->update($data);

            /** End update setting alert device */

            Alert::toast('Data successfully updated', 'success');
            return redirect()->route('instance.index');
        } catch (Exception $e) {
            DB::rollback();
            Alert::toast('Data failed to save.', 'error');
            return redirect()->route('instance.index');
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instance  $instance
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instance = Instance::findOrFail($id);
        try {
            $response = Http::withHeaders(['x-access-token' => setting_web()->token_callback])
                ->withOptions(['verify' => false])
                ->post(setting_web()->endpoint_nms . '/openapi/app/delete', [
                    "appIDs" => [$instance->appID],
                ]);



            if ($instance->delete()) {
                Alert::toast('Data deleted successfully', 'success');
                return redirect()->back();
            } else {
                Alert::toast('Data Failed to delete', 'error');
                return redirect()->back();
            }
        } catch (Exception $e) {
            Alert::toast('Data Failed to delete', 'error');
            return redirect()->back();
        }
    }
}
