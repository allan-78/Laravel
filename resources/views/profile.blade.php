@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ __('Profile') }}</h4>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ Auth::user()->profile_photo }}" alt="Profile Photo" class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <i class="fas fa-user text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        
                        <div class="mt-3">
                            <h3>{{ Auth::user()->name }}</h3>
                            @if(Auth::user()->hasVerifiedEmail())
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i> Verified
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-exclamation-circle me-1"></i> Not Verified
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="list-group list-group-flush mb-4">
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-sm-4 fw-bold">{{ __('Name') }}</div>
                                <div class="col-sm-8">{{ Auth::user()->name }}</div>
                            </div>
                        </div>
                        
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-sm-4 fw-bold">{{ __('Email') }}</div>
                                <div class="col-sm-8">
                                    {{ Auth::user()->email }}
                                    @if(Auth::user()->hasVerifiedEmail())
                                        <span class="text-success ms-2"><i class="fas fa-check-circle"></i></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary px-4">
                            <i class="fas fa-edit me-1"></i> {{ __('Edit Profile') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Profile page specific JS can go here
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Profile page loaded');
    });
</script>
@endsection

@endsection