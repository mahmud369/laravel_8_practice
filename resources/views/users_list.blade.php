@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="justify-content:right !important">
        <div class="col-md-11">
            @if(session('alert_type'))
                <div class="alert alert-{{ session('alert_type') }} alert-dismissible fade show" role="alert">
                    {{ session('alert_message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('List of All Users') }}</div>

                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th style="width:3%">ID</th>
                            <th style="width:10%">Name</th>
                            <th>Files</th>
                            <th style="width:40%">Upload Here</th>
                        </tr>
                        @foreach ($all_users as $each_user)
                            <tr>
                                <td>{{ $each_user['id'] }}</td>
                                <td>{{ $each_user['name'] }}</td>
                                <td> 
                                    @if( isset($all_files[$each_user['id']]) )
                                        <ol>
                                            @foreach ($all_files[$each_user['id']] as $each_file)
                                                <li>
                                                    {{ $each_file['file_name'] }}
                                                    <a href="{{ route('delete-file', ['id' => $each_file['id']]) }}" 
                                                        onclick="return confirm('Sure to Delete?');"
                                                        style="float:right; text-decoration:none; font-weight:bold"
                                                        title="Delete this File"> X </a> 
                                                </li>
                                            @endforeach
                                        </ol>
                                    @else
                                        <i>Empty</i> 
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('save-file') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $each_user['id'] }}"/>
                                        <input type="file" class="file" name="file"/>
                                        <input type="submit" value="Upload" />
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
