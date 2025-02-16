<div class="card" style="max-height:500px; overflow-y:scroll ">
    <table class="table table-no-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        @if (@$apartments->count() > 0)
            <tbody id="favorite-list">

                @foreach ($apartments as $apartment)
                    <tr id="apartment-{{ $apartment->id }}">
                        <td>
                            <img src="{{ asset('storage/' . $apartment->property_image) }}" class="img-fluid"
                                alt="Product Image" style="width: 100px;">
                        </td>
                        <td>
                            <h5 class="mt-2">{{ $apartment->property_name }}</h5>
                            <p>{!! \Illuminate\Support\Str::limit(strip_tags($apartment->property_description), 70, '...') !!}</p>
                        </td>
                        <td>
                            <p class=" ">
                                <del class="text-danger small">Rs. {{ $apartment->property_price }}</del><br>
                                Rs. {{ $apartment->property_sell_price }}
                            </p>
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="favorite-link text-warning"
                                onclick="toggleFavorite({{ Auth::id() }}, {{ $apartment->id }})"
                                title="Toggle Favorite" id="favorite-btn-{{ $apartment->id }}">
                                <i class="fas fa-heart fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        @else
            <tr>
                <td colspan="4" class="text-center">No favorites found.</td>
            </tr>
        @endif
    </table>
</div>
<script>
    function toggleFavorite(userId, propertyId) {
        $.ajax({
            url: "{{ route('favorites.toggle') }}",
            method: "POST",
            data: {
                user_id: userId,
                property_id: propertyId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.isFavorite === false) {
                    // Remove the item from the list instantly
                    $("#apartment-" + propertyId).fadeOut(300, function() {
                        $(this).remove();
                        reloadFavorites(); // Refresh the list after removing
                    });
                } else if (response.isFavorite === true) {
                    reloadFavorites(); // Reload the list if added
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    // Function to reload favorite items dynamically without refreshing the page
    function reloadFavorites() {
        $.ajax({
            url: "{{ route('profile.myFavourites') }}",
            method: "GET",
            success: function(response) {
                if (response.html) {
                    $("#favorite-list").html(response.html);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
