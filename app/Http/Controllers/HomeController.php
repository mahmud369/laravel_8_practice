<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
// Helper
use App\Helpers\UploadHelper;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function users_list()
    {
        $all_users = User::all()->toArray();
        $all_files = $this->get_user_all_files();
        return view('users_list')->with(['all_users' => $all_users, 'all_files'=>$all_files]);
    }

    public function get_user_all_files()
    {
        $temp_files = Document::all()->toArray();
        $files = [];
        foreach($temp_files as $temp_file) {
            $files[$temp_file['user_id']][] = $temp_file;
        }
        return $files;
    }

    public function save_file(Request $request)
    {
        $insert_item = [];
        DB::beginTransaction();
        try {
            // Upload file & get path
            $file_info = UploadHelper::uploadFile($request, 'user_documents');
            if ($file_info) {
                $insert_item = [
                    'file_name' => $file_info['file_name'],
                    'file_path' => $file_info['file_path'],
                    'user_id' => $request->input('user_id')
                ];
            }

            Document::create($insert_item);
            DB::commit(); // IF everything okay THEN commit
            $request->session()->flash('alert_type', 'success');
            $request->session()->flash('alert_message', 'Successfully Saved');
        } catch (\Exception $e) {
            DB::rollback(); // ELSE throw exception and rollback
            $request->session()->flash('alert_type', 'danger');
            $request->session()->flash('alert_message', 'Failed to Save. ( REASON: '.$e->getMessage().' )');
        }

        return redirect()->route('users-list');
    }

    public function delete_file(Request $request, $id = 0)
    {
        $delete_file = Document::find($id);
        $delete_file_array = $delete_file->toArray();
        // print_r($delete_file_array);
        // die(3454356546546);

        DB::beginTransaction();
        try {
            // Delete file & record
            $file_info = UploadHelper::deleteFile($delete_file_array['file_path']);
            if ($file_info) {
                $delete_file->delete();
            }
            DB::commit(); // IF everything okay THEN commit
            $request->session()->flash('alert_type', 'success');
            $request->session()->flash('alert_message', 'Successfully Deleted');
        } catch (\Exception $e) {
            DB::rollback(); // ELSE throw exception and rollback
            $request->session()->flash('alert_type', 'danger');
            $request->session()->flash('alert_message', 'Failed to Delete. ( REASON: '.$e->getMessage().' )');
        }

        return redirect()->route('users-list');
    }
}
