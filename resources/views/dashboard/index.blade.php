@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title">Dashboard</h2>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col">
							<a href="{{ route('dashboard.account.add') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-2"></i> Baru</a>
						</div>
					</div>
					<div class="row">
						@foreach($results as $result)
						<div class="col-lg-3 col-6">
				            <div class="small-box bg-white">
				              <div class="inner h4 pt-4">
				                <span style="font-size: 1.2rem;font-weight: bold;">{{ $result->name }}</span>

				                <p></p>
				              </div>
				              <div class="icon">
				                <i class="ion {{ (strtolower($result->name) == 'other') ? 'ion-grid' : 'ion-social-'.strtolower($result->name) }}"></i>
				              </div>
				              <a href="{{ route('dashboard.account', strtolower($result->name)) }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
				            </div>
			          	</div>
			          	@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Masukkan Secret Key</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
        	<label for="key">Secret Key</label>
        	<input type="text" class="form-control" name="key">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary save-btn">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')

<script>
@if(Cache::get('secretkey') == null)
	$('#staticBackdrop').modal('show');
@endif
$('.save-btn').click(function(){
	$.ajax({
		'url': '{{ route('dashboard.key') }}',
		'method': 'POST',
		'data': {
			key: $('[name="key"]').val(),
			_token: '{{ csrf_token() }}'
		},
		'success': function(response) {
			if(response === 'ok'){
				$('#staticBackdrop').modal('hide');
			}
		}
	});
});
</script>

@endsection