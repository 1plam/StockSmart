@component('mail::message')
    # Exclusive Discount Just for You!

    We've got a special offer that's too good to miss. Use the discount code below to save on your next purchase!

    ## Your Discount Code

    **Code:** `{{ $discountCode }}`

    @component('mail::panel')
        - **Discount Amount:** €5.00
        - **Valid for:** 1 Month
    @endcomponent

    @component('mail::button', ['url' => url('/')])
        Shop Now
    @endcomponent

    Thank you for being a valued customer!

@endcomponent
