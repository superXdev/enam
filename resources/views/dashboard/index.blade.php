@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title">Dashboard</h2>
					<div class="card-tools">
						<a href="{{ route('dashboard.account.add') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-2"></i> Baru</a>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col mb-3">
							<b>Total akun: </b>{{ $totalAccount }}
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


@endsection