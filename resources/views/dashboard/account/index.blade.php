@extends('layouts.app')

@section('title', 'Akun '.$service->name)
@section('content')
<div class="row">
	<div class="col-lg-12">
		@if(session()->has('deleted'))
		<div class="alert alert-danger">{{ session()->get('deleted') }}</div>
		@endif
		@if(session()->has('message'))
		<div class="alert alert-primary">{{ session()->get('message') }}</div>
		@endif
		<div class="card">
		  <div class="card-header">
		    <h3 class="card-title">Akun {{ $service->name }}</h3>

		    <div class="card-tools">
		      <a href="{{ route('dashboard.account.add') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Baru</a>
		    </div>
		  </div>
		  <!-- /.card-header -->
		  <div class="card-body table-responsive p-0">
		    <table class="table table-hover text-nowrap">
		      <thead>
		        <tr>
		          <th>Layanan</th>
		          <th>Akun</th>
		          <th>Tags</th>
		          <th>Status</th>
		          <th></th>
		        </tr>
		      </thead>
		      <tbody>
		      	@forelse($accounts as $account)
		      	@php
		      	$data = (object)$account->showData(Cache::get('secretkey'));
		      	@endphp
		      	<tr data-id="{{ $account->id }}" data-username="{{ $data->username }}" data-password="{{ $data->password }}" data-note="{{ $account->note }}" data-status="{{ $account->status }}" data-created="{{ $account->created_at }}">
		      		<td><a class="btn btn-info btn-sm w-100" href="{{ $account->service->url }}">{{ $account->service->name }}</a></td>
		      		<td>{{ $data->username }}</td>
		      		<td>
		      			@foreach($account->tags as $tag)
		      			<a href="{{ route('dashboard.account.tag', ['service' => strtolower($account->service->name), 'tag' => $tag->slug]) }}"><span class="badge badge-secondary">{{ $tag->name }}</span></a>
		      			@endforeach
		      		</td>
		      		<td>
		      			<span class="text-{{ ($account->status == 'active') ? 'success' : 'danger'}}">{{ $account->status }}</span>
		      		</td>
		      		<td>
		      			<div class="text-center">
		      				<button class="btn btn-primary btn-sm info"><i class="fas fa-eye"></i></button>
		      				<form class="d-inline" action="{{ route('dashboard.account.delete', $account->id) }}" method="post">
		      					@csrf
		      					<button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
		      				</form>
		      			</div>
		      		</td>
		      	</tr>
		      	@empty
		      	<tr>
		      		<td>Kosong</td>
		      	</tr>
		      	@endforelse
		      </tbody>
		  </table>
		</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-info" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Informasi Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      	<div class="row mb-2">
      		<div class="col-md-3"><b>Situs/Layanan</b></div>
      		<div class="col-md-9"><a href="{{ $service->url }}">{{ $service->name }}</a></div>
      	</div>
      	<div class="row mb-2">
      		<div class="col-md-3"><b>Username</b></div>
      		<div class="col-md-9" id="username-info"></div>
      	</div>
      	<div class="row mb-2">
      		<div class="col-md-3"><b>Password</b></div>
      		<div class="col-md-9" id="password-info"></div>
      	</div>
      	<div class="row mb-2">
      		<div class="col-md-3"><b>Status</b></div>
      		<div class="col-md-9" id="status-info"></div>
      	</div>
      	<div class="row mb-2">
      		<div class="col-md-3"><b>Catatan</b></div>
      		<div class="col-md-9" id="note-info"></div>
      	</div>
      	<div class="row mb-5">
      		<div class="col-md-3"><b>Tanggal dibuat</b></div>
      		<div class="col-md-9" id="created-info"></div>
      	</div>
      	<div class="row mb-2">
      		<div class="col-md-8">
      			<div class="row">
      				<div class="col-6">
      					<a href="" class="btn btn-primary w-100" id="edit">Edit</a>
      				</div>
      				<div class="col-6">
      					<form action="#" method="post" id="form-status">
      						@csrf
      						<button type="submit" href="" class="btn btn-secondary w-100">Nonaktifkan</button>
      					</form>
      					
      				</div>
      			</div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
	$('.info').click(function(){
		const el = $(this).parent().parent().parent();
		const status = (el.data('status') == 'active') ? `<span class="text-info">${el.data('status')}</span>` : `<span class="text-danger">${el.data('status')}</span>`;
		$('#username-info').html(el.data('username'));
		$('#password-info').html(el.data('password'));
		$('#status-info').html(status);
		$('#note-info').html(el.data('note'));
		$('#created-info').html(el.data('created'));
		$('#edit').attr('href', `/dashboard/account/${el.data('id')}/edit`)

		$('#form-status').attr('action', `/dashboard/account/${el.data('id')}/togglestatus`);
		$('#form-status button').text((el.data('status') == 'active') ? 'Nonaktifkan' : 'Aktifkan')

		$('#modal-info').modal('show');
	});
</script>
@endsection