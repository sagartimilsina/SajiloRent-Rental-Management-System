@php
    $favoriteIds = $favoriteIds ?? [];
@endphp

<div class="row justify-content-center">
    @if ($properties->count() > 0)
        @foreach ($properties as $apartment)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card h-100 shadow-sm">
                    <a href="{{ route('property.details', ['id' => $apartment->id]) }}" class="text-decoration-none">
                        <img alt="{{ $apartment->property_name }}" class="card-img-top img-fluid"
                            src="{{ asset('storage/' . $apartment->property_image) }}" />
                        <div class="card-body">
                            <h5 class="card-title text-truncate">
                                {{ $apartment->property_name }}</h5>
                            <p class="card-text text-justify">
                                {!! \Illuminate\Support\Str::limit(strip_tags($apartment->property_description), 70, '...') !!}
                            </p>
                            <p class="card-text small text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $apartment->property_location }}
                            </p>
                            <div class="price mt-2">
                                <p class="text-center d-flex align-items-center justify-content-between">
                                    <del class="text-danger small">Rs.
                                        {{ $apartment->property_price }}</del>
                                    Rs.
                                    {{ $apartment->property_sell_price }}
                                </p>
                            </div>
                        </div>
                    </a>
                    <div
                        class="card-footer bg-white border-0 d-flex justify-content-between align-items-center favorite-link">
                        <!-- Share Button -->
                        <a href="javascript:void(0);" class="text-warning"
                            onclick="shareProperty('{{ route('property.details', ['id' => $apartment->id]) }}')"
                            style="position: relative;" title="Share this property">
                            <i class="fas fa-share-alt fa-lg"></i>
                        </a>
                        <!-- Add to Favorites Link -->
                        <a href="javascript:void(0);"
                            class="favorite-link {{ in_array($apartment->id, $favoriteIds) ? 'text-warning' : 'text-warning' }} "
                            onclick="toggleFavorite({{ Auth::id() }}, {{ $apartment->id }})"
                            title="Add to Favorites">
                            <i
                                class="{{ in_array($apartment->id, $favoriteIds) ? 'fas fa-heart' : 'far fa-heart' }} fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-5">
            <p class="h5 text-muted">No properties available at the moment.</p>
        </div>
    @endif
</div>

<!-- Pagination -->
<div class="pagination-container">
    {{ $properties->links() }}
</div>
