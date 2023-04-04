<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Property;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{





    public function adminRegister(Request $request){
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'key'=>'required',
                'phone'=>'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if($request->key!="Sikkena@123"){
                return response()->json('you dont have the permission to add new agent', 200,);
            }
            $user = new User;
            $user->name=$request->name;
            $user->email=$request->email;
            $user->phone=$request->phone;
            $user->password=Hash::make($request->password);
            $user->isAdmin=true;
            $user->save();


            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function index(){

        if(Auth::user()->isAdmin){
            $users=User::with('propertiesCount')->get();
        return response()->json($users, 200,);
        }
        return response()->json('you dont have the permission', 200,);
    }

    public function update(Request $request){
        $user = Auth::user();
        $user->name = request("name");
        $user->phone = request("phone");
        $user->description=request("description");
        $user->about=request("about");

        if($request->hasFile('image')){
           $user->img= $request->file("image")->store('images/agents');
        }
        $user->save();



    }



    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [   'phone'=>'required',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::user()->isAdmin){
                return response()->
                json('you dont have the permission to add new agent', 200,);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone'=> $request->phone,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['success']=true;
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;
            $success['email']=$user->email;
            $success['img']=$user->img;
            $success['description']=$user->description;
            $success['about']=$user->about;
            $success['isAdmin']=$user->isAdmin;

            return response()->json($success, 200);      }
        else{
            $failed["success"]=false;
            $failed["messege"]='Login failed please check your Email or Password';
            return response()->json($failed );
        }
    }

    public function deleteUser($id){
        if(Auth::user()->id ==$id || Auth::user()->isAdmin)
        {
            $user=User::find($id);
            $user->delete();
            return response()->json('deleted successflly', 200, );
        }else{
            return response()->json('you dont have the access to delete this agent', 200, $headers);
        }

    }

    public function profile(){
        $user =Auth::user();
        $success['id']=$user->id;
        $success['name'] =  $user->name;
        $success['email']=$user->email;
        $success['img']=$user->img;
        $success['description']=$user->description;
        $success['about']=$user->about;
        $success['isAdmin']=$user->isAdmin;
        if($user->isAdmin){

        }$success['onHold']=Property::where('confirmed',0);
        return response()->json($success, 200,);
    }

}
