@extends('layouts.app')

@section('content')
    <section class="sample-text-area">
        <div class="container">
            <h3 class="text-heading">Vaš nalog nije verifikovan</h3>

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    Novi verifikacioni kod je poslat na vašu email adresu.
                </div>
            @endif

            <p class="sample-text">
                Pre nastavka, proverite da li je na vašu email adresu stigao verifikacioni kod.
            </p>
            <p class="sample-text">
                Ako niste primili email, <a href="{{ route('verification.resend') }}">kliknite ovde da pošaljete novi zahtev.</a>
            </p>
        </div>
    </section>

    @include('partials.most_search')
@endsection
