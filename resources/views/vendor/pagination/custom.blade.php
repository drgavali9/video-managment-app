@if ($paginator->hasPages())
                <div class="pro-pagination-style text-center">
                    <ul>
					@if ($paginator->onFirstPage())
						<li class="disabled"><a class="prev" href="#"><i class="ion-ios-arrow-left"></i></a></li>
					@else
						<li><a class="prev" href="{{ $paginator->previousPageUrl() }}"><i class="ion-ios-arrow-left"></i></a></li>
					@endif

					@foreach ( $elements  as $blog )
						@if(is_string($blog))
							<li class="disabled"><a href="javascript:">{{ $blog }}</a></li>
						@endif

						@if(is_array($blog))
							@foreach ($blog as $page => $url )
								@if($page == $paginator->currentPage())
									<li><a class="active" href="javascript:">{{$page}}</a></li>
								@else
									<li><a href="{{$url}}">{{$page}}</a></li>
								@endif
							@endforeach
						@endif
					@endforeach

					@if ($paginator->hasMorePages())
						<li><a class="next" href="{{ $paginator->nextPageUrl() }}"><i class="ion-ios-arrow-right"></i></a></li>
					@else
						<li class="disabled"><a  class="next" href="#"> <i class="ion-ios-arrow-right" ></i></a></li>
					@endif
                    </ul>
                </div>
				@endif
                <!--  Pagination Area End -->
