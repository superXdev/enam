@extends('layouts.app')

@section('title', 'Edit')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h4>Tambahkan Akun</h4>
			</div>
			<div class="card-body">
				@if(session()->has('updated'))
				<div class="alert alert-primary">
					{{ session()->get('updated') }}
				</div>
				@endif
				<form action="{{ route('dashboard.account.update', $account->id) }}" method="post">
					@csrf
					@php
					$data = $account->showData(Cache::get('secretkey'));
					@endphp
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Layanan/situs</label>
								<select name="service_id" id="" class="form-control">
									<option value="">Pilih layanan atau situs</option>
									@foreach($services as $service)
									<option value="{{ $service->id }}" {{ ($service->id == $account->service_id) ? 'selected' : '' }}>{{ $service->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="">Username</label>
								<input type="text" class="form-control" name="username" value="{{ $data['username'] }}">
							</div>
							<div class="form-group">
								<label for="">Password</label>
								<input type="password" class="form-control" name="password" value="{{ $data['password'] }}">
								<div class="text-secondary text-sm mt-2"><input type="checkbox" name="show"> Tampilkan password </div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Tags</label>
								@php
								$taged = $account->tags->pluck('id')->toArray();
								@endphp
			                  <select class="select2" multiple="multiple" data-placeholder="Pilih beberapa tags" name="tags[]" style="width: 100%;">
			                  	@foreach(\App\Models\Tag::get() as $tag)
				                    <option value="{{ $tag->id }}" {{ (in_array($tag->id, $taged)) ? 'selected' :'' }}>{{ $tag->name }}</option>
			                    @endforeach
			                  </select>
							</div>
							<div class="form-group">
								<label for="">Catatan</label>
								<textarea name="note" cols="30" rows="5" class="form-control" placeholder="Catatan tambahan..">{{ $account->note }}</textarea>
							</div>
						</div>
					</div>
					<div class="row col">
						<input type="submit" value="Simpan" class="btn btn-primary">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$('.select2').select2();

	$('[name="show"]').on('change', function(){
		const passwordField = $('[name="password"]');
		if($(this).is(':checked')) {
			passwordField.attr('type', 'text');
		} else {
			passwordField.attr('type', 'password');
		}
	});
</script>
@endsection