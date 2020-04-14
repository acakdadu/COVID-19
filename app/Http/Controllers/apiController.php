<?php

namespace App\Http\Controllers;

use App\User;
use App\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class apiController extends Controller
{

      // Password
      public function auth(Request $request)
      {
          if (!Auth::attempt([
              'emp_id' => $request->emp_id,
              'password' => $request->password
          ]))
          {
              return response()->json(['Error' => 'Credential is Wrong!'], 401);
          }
          return response()->json(['Success' => 'Data Found!'], 200);
      }

    // get all data
    public function index()
    {

        $conn = DB::table('mst_employee')
            ->join('mst_family_member', 'mst_employee.emp_id', '=', 'mst_family_member.emp_id')
            // ->join('mst_family_member', 'mst_family_member.emp_id', '=', 'mst_employee.emp_id')
            ->select('mst_employee.name', 'mst_employee.emp_id', 'mst_family_member.relation' )
            ->orderBy('mst_employee.emp_id','DESC')
            ->get();
       if ($conn) {
           $status = [
               'status' => '200 OK',
               'response' => $conn
            ];
            }


        return response()->json($status);
    }

    // Create New Employee Data
    public function store(Request $request)
    {
        $new_data = User::create([
            'emp_id' => $request->emp_id,
            'name' => $request->name,
            'company' => $request->company,
            'department' => $request->department,
            'team' => $request->team,
            'plant' => $request->plant,
            'password' => $request->password,
            'level' => $request->level
        ]);
        return response()->json('Berhasil Menambahkan Pegawai', 201);
    }

    //    Show data employe order by emp_id
    public function show(User $user, $emp_id)
    {
        $getemp = DB::table('mst_employee')
            ->where('emp_id', $emp_id)
            ->get();
        return response()->json($getemp, 200);
    }

    //   update data
    public function update(Request $request, $emp_id)
    {
        $update = DB::table('mst_employee')->where('emp_id', $emp_id)->update([
            'emp_id' => $request->emp_id,
            'name' => $request->name,
            'company' => $request->company,
            'department' => $request->department,
            'team' => $request->team,
            'plant' => $request->plant,
            'password' => $request->password,
            'level' => $request->level
        ]);
        return response()->json('Data berhasil di Update', 200);
    }

    // delete data employee
    public function destroy($emp_id)
    {
        DB::table('mst_employee')->where('emp_id', $emp_id)->delete();
        return response()->json('Berhasil di hapus', 200);
    }
}
