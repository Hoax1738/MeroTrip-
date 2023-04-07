@extends('layouts.frontend.app')
@section('title') {{ __('List of Payments').' - Tripkhata®' }} @endsection
@section('content')


<section class="content">
    <section class="ftco-section">
        <div class="container">
            @if (Auth::check())
            @include('contents.emiAlert')
            @else
            @endif
            <div class="row justify-content-center pb-4">
                <div class="col-md-6 heading-section text-center ftco-animate">
                    <h2 class="mb-4"> {{ __('Payments') }}</h2>
                </div>
            </div>
            <div>
                <table class="table table-hover">
                    <div class="mb-2">
                        <form action="{{ route('myPayments') }}" method="POST">
                            @csrf
                            <div class="row">
                            <div class="col-sm-12 col-lg-3 mb-2">
                                <select class="form-control" name="title">
                                <option value="">{{ __('Choose Title.') }}.</option>
                                @foreach($title as $row)
                                    <option value="{{ $row->title }}" <?=$setValue['title'] == $row->title ? ' selected="selected"' : '';?> >{{ $row->title }}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-lg-3 mb-2">
                                <select class="form-control" name="method">
                                <option value=""> {{ __('Choose Method..') }}</option>
                                @foreach($method as $row)
                                    <option value="{{ $row->method }}" <?=$setValue['method'] == $row->method ? ' selected="selected"' : '';?> >{{ $row->method }}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-lg-3 mb-2">
                                <select class="form-control" name="type">
                                <option value=""> {{ __('Choose Payment Type..') }}</option>
                                @foreach($type as $row)
                                    <option value="{{ $row->type }}" <?=$setValue['type'] == $row->type ? ' selected="selected"' : '';?> >{{str_replace("_"," ",$row->type)}}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-lg-2  ">
                                <button type="submit" class="btn btn-outline-dark form-control"> {{ __('Search') }}</button>
                            </div>
                            </div>
                        </form>
                    </div>

                    <thead class="text-dark">
                        <th>{{ __('ID ') }}</th>
                        <th>{{ __('Package Title ') }}</th>
                        <th>{{ __('Payment Type') }}</th>
                        <th>{{ __('Payment Method') }}</th>
                        <th>{{ __('Payment Date') }}</th>
                        <th>{{ __('Payment Status') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th><a href="{{ url('/payments-pdf') }}"><i class="fas fa-print fa-lg"></i></a></th>

                    </thead>
                    <tbody>
                        @forelse ($payments as $key=>$payment)
                        <tr>
                        <td>
                            {{__(++$key)}}
                        </td>
                        <td>
                            {{__($payment->package_title)}}
                        </td>
                        <td>
                            {{__(str_replace("_"," ",$payment->type))}}
                        </td>
                        <td>
                            {{__($payment->method)}}
                        </td>
                        <td>
                            {{ date("M j, Y",strtotime($payment->created_at)) }}
                        </td>
                        <td>
                            {{__($payment->payment_status)}}
                        </td>

                        <td class="text-dark">
                            {{$payment->amount}}
                        </td>
                        <td>
                            <a href="{{ url('/single-payment',$payment->invoice_id) }}"><i class="fas fa-print"></i></a>
                        </td>
                        </tr>
                        @empty
                        <td colspan="7" style="text-align:center;">*{{ __('No Payments Record Found') }}</td>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-row-reverse">
                {{ $payments->appends(Request::except('_token'))->links()}}
            </div>

        </div>
    </section>
</section>

@endsection
