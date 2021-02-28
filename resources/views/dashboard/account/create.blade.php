@extends('layouts.app')

@section('title', 'Akun Baru')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h4>Tambahkan Akun</h4>
			</div>
			<div class="card-body">
				@if(session()->has('success'))
				<div class="alert alert-success">
					{{ session()->get('success') }}
				</div>
				@endif
				<form action="{{ route('dashboard.account.store') }}" method="post">
					@csrf
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Layanan/situs</label>
								<select name="service_id" id="" class="form-control">
									<option value="">Pilih layanan atau situs</option>
									@foreach($services as $service)
									<option value="{{ $service->id }}">{{ $service->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="">Username</label>
								<input type="text" class="form-control" name="username" value="{{ old('username') }}">
							</div>
							<div class="form-group">
								<label for="">Password</label>
								<input type="password" class="form-control" name="password" value="{{ old('password') }}">
								<div class="text-secondary text-sm mt-2"><input type="checkbox" name="show"> Tampilkan password </div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Tags</label>
			                  <select class="select2" multiple="multiple" data-placeholder="Pilih beberapa tags" name="tags[]" style="width: 100%;">
			                    @foreach(App\Models\Tag::all() as $tag)
			                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
			                    @endforeach
			                  </select>
							</div>
							<div class="form-group">
								<label for="">Catatan</label>
								<textarea name="note" cols="30" rows="5" class="form-control" placeholder="Catatan tambahan.." value="{{ old('note') }}"></textarea>
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