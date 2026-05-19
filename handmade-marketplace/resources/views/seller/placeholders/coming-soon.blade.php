@extends('layouts.seller')
@section('page-title', $title ?? 'Coming soon')

@section('content')
<x-empty-state :title="$title ?? 'Coming soon'" :description="'The '.$module.' module will be added in a future sprint. Focus is on polishing existing seller workflows first.'">
    <x-slot name="icon">🚧</x-slot>
    <x-slot name="action"><a href="{{ route('seller.dashboard') }}" class="cn-btn-primary">Back to dashboard</a></x-slot>
</x-empty-state>
@endsection
