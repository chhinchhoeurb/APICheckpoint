<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use validation;
use Illuminate\Http\Request;
use App\Students;
use DB;
use Illuminate\Validation\Rule;
class StudentsController extends Controller
{
    //function for view students
    public function index(Request $request)
    {
        $getStudents = Students::all();
        if($getStudents == true){
            return response()->json($getStudents);
        }else{
            echo "no record";
        }
    }
    //function to search student by username address and status
    public function search(Request $request){
        $username = $request->input('username');
        $address = $request->input('address');
        $status = $request->input('status');
        $search = DB::table('students')->select('*')
            ->where([
                ['username', '=', $username],
                ['address', '=', $address],
                ['status', '=', $status],
            ])->get();
        if(count($search) > 0){
            return response()->json($search);
        }else{
            return response(array(
                'error' => false,
                'message' =>'No record',
            ),404);
        }
    }
    //function for login
    public function login(Request $request){
        $validator = Validator::make($request->all(), [//check validation required
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);//return message error
        }else{
            $email = $request->email;
            $password = $request->password;
            $login = DB::table('students')->select('*')->where([
                ['email','=',$email],
                ['password','=',sha1($password)]
            ])->get();
            if(count($login) > 0){//check is true or not
                return response()->json($login);
            }else{
                return response()->json(array(
                    'error'=>false,
                    'message'=> 'Login not success, Please try again!!'
                ));
            }
       }
    }
    // funtion for register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|alpha',
            'email' => 'required|email|unique:students',
            'phone' => 'required|numeric',
            'address' => 'required',
            'status' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
               return response()->json(['errors'=>$validator->errors()]);//return message error
        }else{
            $student = new students;
            $student->password = sha1($request->input('password'));
            $student->username = $request->input('username');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->status = $request->input('status');
            $student->address = $request->input('address');
            $student->save();
            return response(array(
                'message' =>'Student created successfully',
            ),200);
        }
    }
    //function for view student by id
    public function show($id){
        $student = Students::find($id);
        if($student){
            return response()->json($student);
        }else{
            return response(array(
                'message' =>'No record',
            ),200);
        }
    }
    //function for update
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|alpha',
            'email' => [Rule::unique('students')->ignore($request->id, 'id'),"required","email"],
            'phone' => 'required|numeric',
            'address' => 'required',
            'status' => 'required',
            'password' => 'required|min:6|max:15',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);//return message error
        }else{
                    $student = students::find($id);
                    $student->password = sha1($request->input('password'));
                    $student->username = $request->input('username');
                    $student->email = $request->input('email');
                    $student->phone = $request->input('phone');
                    $student->status = $request->input('status');
                    $student->address = $request->input('address');
                    $student->save();
                    $updateStudent = Students::find($id);//to get the value from update
                    return response()->json($updateStudent);
             }
        }
    // function to delete student
    public function destroy($id)
    {
        $deleteStudents = Students::find($id);
        if($deleteStudents == true){
            Students::find($id)->delete();
            return response(array(
                'message' =>'Deleted Successfully',
            ),200);
        }else{
            return response(array(
                'message' =>'In valid ID',
            ),404);
        }
    }
}
