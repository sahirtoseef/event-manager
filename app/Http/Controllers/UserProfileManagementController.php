<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Helper;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use App\UserEvent;

class UserProfileManagementController extends Controller {

	public function getProfile( $user_id = 0 ) {
		if ( ! $user_id ) {
			$user = Auth::user();
			if ( $user->role_id == 1 ) {
				return view( 'admin.profile' )->with( 'user', Auth::user() );
			} else if ( $user->role_id == 2 ) {
                                $auth = Auth::user();
				return view( 'manager.profile' )->with( compact( 'user', 'auth') );
			} else if ( $user->role_id == 3 ) {
				return view( 'client.profile' )->with( 'user', Auth::user() );
			}
		} else {
			$user = User::find( $user_id );
			return view( 'admin.profile' )->with( 'user', $user );
		}
	}

	public function profileUpdate( Request $request, $id ) {
		$this->validate( $request, [
		    'name' => 'required',
		    'email' => 'required',
		] );

		$user = User::find( $id );
		$user->name = $request->get( 'name' );
		$user->email = $request->get( 'email' );
		$user->address = ($request->get( 'address' )) ? $request->get( 'address' ) : "N/A";
		$user->phone = ($request->get( 'phone' )) ? $request->get( 'phone' ) : "N/A";

		$avatar_link = Helper::saveFileToFolder( $request, 'avatar' );
		if ( $avatar_link ) {
			$user->avatar = $avatar_link;
		}

		if ( $request->get( 'old-password' ) && $request->get( 'new-password' ) ) {
			if ( Hash::check( $request->get( 'old-password' ), $user->password ) ) {
				$user->password = Hash::make( $request->get( 'new-password' ) );
				$user->save();
				session()->flash( 'success', "Profile Updated Successfully!!" );
			} else {
				session()->flash( 'error', "Old password is incorrect" );
			}
		} else {
			$user->save();
			session()->flash( 'success', "Profile Updated Successfully!!" );
		}

		if ( $user->role_id == 1 ) {
			return redirect( 'admin/profile' );
		} else if ( $user->role_id == 2 ) {
			return redirect( 'manager/profile' );
		} else if ( $user->role_id == 3 ) {
			return redirect( 'client/profile' );
		}
	}

	public function createClient() {
		return view( 'client.createclient' );
	}

	public function storeClient( Request $request ) {
		$password = $request->get( 'password' );
		$this->validate( $request, [
		    'name' => 'required',
		    'email' => 'required',
		    'password' => 'confirmed'
		] );
		if ( ! $password ) {
			$password = Helper::generateRandomPassword();
		}

		$user = new User();
		$user->name = $request->get( 'name' );
		$user->email = $request->get( 'email' );
		$user->password = Hash::make( $password );
		$user->role_id = $request->get( 'role_id' );
		$user->address = ($request->get( 'address' )) ? $request->get( 'address' ) : "N/A";
		$user->phone = ($request->get( 'phone' )) ? $request->get( 'phone' ) : "N/A";

		if ( ! User::where( 'email', '=', $request->get( 'email' ) )->exists() ) {
			$user->avatar = Helper::saveFileToFolder( $request, 'avatar' );
			$user->save();
			if ( $request->get( 'send-email' ) ) {
				$this->mail( $password, $request->get( 'email' ) );
			}
			session()->flash( 'success', "Client created" );
		} else {
			session()->flash( 'error', "Client with this email already exists." );
		}
		return redirect( 'admin/create-client' );
	}

	public function createManager() {
		return view( 'manager.createmanager' );
	}

	public function storeManager( Request $request ) {
		$password = $request->get( 'password' );
		$this->validate( $request, [
		    'name' => 'required',
		    'email' => 'required',
		    'password' => 'confirmed'
		] );
		$user = new User();

		if ( ! $password ) {
			$password = Helper::generateRandomPassword();
		}

		$user->name = $request->get( 'name' );
		$user->email = $request->get( 'email' );
		$user->password = Hash::make( $password );
		$user->role_id = $request->get( 'role_id' );
		$user->address = ($request->get( 'address' )) ? $request->get( 'address' ) : "N/A";
		$user->phone = ($request->get( 'phone' )) ? $request->get( 'phone' ) : "N/A";

		if ( ! User::where( 'email', '=', $request->get( 'email' ) )->exists() ) {
			$user->avatar = Helper::saveFileToFolder( $request, 'avatar' );
			$user->save();
			if ( $request->get( 'send-email' ) ) {
				$this->mail( $password, $request->get( 'email' ) );
			}
			session()->flash( 'success', "Manager created" );
		} else {
			session()->flash( 'error', "Client with this email already exists." );
		}
		return redirect( 'admin/create-manager' );
	}

	public function editClientManager( $user_id ) {
		return view( 'admin.editclientmanager' )->with( 'user', User::find( $user_id ) );
	}

	public function updateClientManager( Request $request, $user_id ) {
		$this->validate( $request, [
		    'name' => 'required',
		    'email' => 'required',
		] );
		$user = User::find( $user_id );
		$user->name = $request->get( 'name' );
		$user->email = $request->get( 'email' );
		if ( $request->get( 'password' ) ) {
			$user->password = Hash::make( $request->get( 'password' ) );
		}

		$user->address = ($request->get( 'address' )) ? $request->get( 'address' ) : "N/A";
		$user->phone = ($request->get( 'phone' )) ? $request->get( 'phone' ) : "N/A";

		$avatar_link = Helper::saveFileToFolder( $request, 'avatar' );
		if ( $avatar_link ) {
			$user->avatar = $avatar_link;
		}
		$user->save();
		session()->flash( 'success', "User Updated" );

		return Redirect::route( 'edit-client-manager', ['user_id' => $user_id ] );
	}

	public function deleteClientManager( $user_id ) {
		$response = array( 'error' => false, 'message' => 'User deleted' );
		try {
			$user = User::find( $user_id );
			$user->status = 0;
			$user->save();
			if ( $user->role_id == 2 ) {
				UserEvent::where( 'user_id', '=', $user_id )->delete();
			}
		} catch ( \Illuminate\Database\QueryException $exception ) {
			$response[ 'error' ] = true;
			$response[ 'message' ] = "Error happend";
		}
		die( json_encode( $response ) );
	}

	public function mail( $password, $email ) {
		Mail::to( $email )->send( new SendMailable( $password ) );
		return 'Email was sent';
	}

}
        