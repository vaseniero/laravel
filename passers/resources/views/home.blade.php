@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>2018 PSHS NCE Passers</h3>
                    Click <a href="{{ url('/school') }}">here</a> for List of School Passers
                </div>
            </div>
        </div>
    </div>
</div>
<div id="app" style="padding-top:25px;">
	<div class="container">
		<data-table-search
			fetch-url="{{ route('examinees.table') }}"
			:columns="['examinee', 'campus', 'school' , 'division']"></data-table-search>
	</div>
</div>
@endsection
