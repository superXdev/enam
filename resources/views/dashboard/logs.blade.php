@extends('layouts.app')

@section('title', 'Logs')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title">Logs</h2>
				</div>
				<div class="card-body">
					<table class="table table-bordered">
						<thead>
							<th>Tanggal</th>
							<th>Akun</th>
							<th>Aksi</th>
						</thead>
						<tbody>
							@foreach($logs as $log)
							<tr>
								<td>{{ $log->created_at->format('d M Y - s:m:h A') }}</td>
								<td>{{ $log->service }}</td>
								<td>
									@if($log->action == 'create')
									<span class="badge badge-success badge-sm ">create</span>
									@elseif($log->action == 'update')
									<span class="badge badge-primary badge-sm ">update</span>
									@elseif($log->action == 'delete')
									<span class="badge badge-danger badge-sm ">delete</span>
									@else
									<span class="badge badge-secondary badge-sm ">{{ $log->action }}</span>
									@endif
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					
				</div>
				<div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  {{ $logs->links() }}
                </ul>
              </div>
			</div>
		</div>
	</div>
</div>
@endsection