@extends('admin.layouts.print.blank')

@section('subject', $data['translation'][242])

@section('content')
    <table width="100%" style="width: 610px;">
        <tr>
            <td align="left" style="padding-left: 15px;">
                <span style="font-weight: bold; font-size: 14px; width: 100%; float: left; color: #333;">
                    {{ $data['translation'][242] }}
                </span>
                <br/>
                <span style="width: 100%; float: left; font-size: 13px; color: #666;">
                    {{ $data['voucher_date'] }}
                </span>
            </td>
            <td align="right">
                <img style="float: right; overflow: hidden;" height="35px" src="{{ $data['logo'] }}" alt="logo"/>
            </td>
        </tr>
        <tr>
            <td align="left" style="width: 100%; font-weight: bold; color: #ff0000; text-align: center;">
                {{ $data['translation'][193] }}
            </td>
        </tr>
        <tr>
            <td align="left" style="width: 100%; margin: 10px 0; padding-left: 15px; color: #666;">
                {{ $data['translation'][230] }} {{ htmlspecialchars($data['booking_username']) }}
            </td>
        </tr>
        <tr>
            <td align="left" style="width:100%;margin:10px 0;font-weight:bold;color:#333;padding-left: 15px;">
                <u>{{ $data['translation'][194] }} {{ $data['booking_number'] }}</u>
            </td>
        </tr>
    </table>
    <div style="float: left; width: 100%;">
        <table width="600" border="0">
            <tr style="font-size:13px;color:#666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][224] }}:
                </td>
                <td style="padding-left: 15px;">
                    {{ htmlspecialchars(implode(', ', $data['guests'])) }}
                </td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px">
                    {{ $data['translation'][217] }}:
                </td>
                <td style="padding-left: 15px;">
                    {{ $data['hotel_name'] }}
                </td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px">
                    {{ $data['translation'][222] }}:
                </td>
                <td style="padding-left: 15px;">
                    {{ $data['hotel_address'] }}
                </td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px">
                    {{ $data['translation'][228] }}:
                </td>
                <td style="padding-left: 15px;">
                    {{ $data['booking_email'] }}
                </td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][244] }}:
                </td>
                <td style="padding-left: 15px;">
                    {{ $data['booking_checkin'] }}
                </td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space:nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][229] }}:
                </td>
                <td style="padding-left: 15px;">
                    {{ $data['booking_checkout'] }}
                </td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][206] }}:
                </td>
                <td style="padding-left: 15px;">
                    {{ implode('<br/>', $data['room_type']) }}
                </td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][209] }}:
                </td>
                <td style="padding-left: 15px;">{{ $data['rooms'] }}</td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][245] }}:
                </td>
                <td style="padding-left: 15px;">{{ $data['adults'] }}</td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][237] }}:
                </td>
                <td style="padding-left: 15px;">{{ $data['children'] }}</td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][208] }}:
                </td>
                <td style="padding-left: 15px;">
                    {{ $data['translation'][1226] }}
                </td>
            </tr>
            @if($data['package_enabled'])
                <tr style="font-size: 13px; color: #666;">
                    <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                        {{ $data['translation'][198] }}:
                    </td>
                    <td style="padding-left: 15px;">
                        {{ $data['amount'] }} {{ $data['currency'] }}
                    </td>
                </tr>
                <tr style="font-size: 13px; color: #666;">
                    <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                        {{ $data['translation'][197] }}:
                    </td>
                    <td style="padding-left: 15px;">0,-</td>
                </tr>
            @else
                @if($data['extra_nights'])
                    <tr style="font-size: 13px; color: #666;">
                        <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                            {{ $data['translation'][198] }}:
                        </td>
                        <td style="padding-left: 15px;">
                            {{ $data['extra_nights_amount'] }} {{ $data['extra_nights_currency'] }}
                        </td>
                    </tr>
                @endif
            @endif
        </table>
        @if($data['show_all_booking_non_refund'])
            <div style="margin: 10px 0 10px 15px; font-weight: bold; color: #333;">
                <u>{{ $data['translation'][238] }}:</u>
            </div>
            <div class="message_box_success" style="margin: 5px 0 10px 15px; font-size: 13px; color: #666;">
                {{ $data['translation'][498] }}
            </div>
        @else
            <div style="margin: 10px 0 10px 15px; font-weight: bold; color: #333;">
                <u>{{ $data['translation'][238] }}:</u>
            </div>
            <div style="margin: 5px 15px 10px 15px; font-size: 13px; color: #666;">
                @if($data['provider_name'] === 'grn')
                    @if($data['show_all_booking_non_refund'] || !$data['refundable'])
                        {{ $data['translation'][498] }}
                    @else
                        {{ $data['translation'][499] }} {{ $data['expiration_date'] }}, {{ $data['translation'][496] }}
                    @endif
                @else
                    @if($data['provider_name'] === 'hotelbed')
                        {{ $data['cancellation_policy'] }}
                    @else
                        {{ $data['translation'][499] }}
                    @endif
                @endif
            </div>
            @if($data['booking_hash'])
                <div style="margin-left: 15px; font-size: 13px; color: #666;">
                    {{ $data['translation'][199] }}
                    <a style="color: #0080C0" href="{{ $data['cancel_booking_url'] }}"> {{ $data['translation'][236] }}</a>
                </div>
            @endif
        @endif
        <div>
            <div style="margin: 10px 0 10px 15px; font-weight: bold; color: #333;">
                <u>{{ $data['translation'][247] }}:</u>
            </div>
            <div style="margin: 5px 15px 10px 15px; font-size: 13px; color: #666;">
                {{ $data['translation'][200] }}
            </div>
        </div>
        <div style="border-top: 1px solid #ccc;">
            <div style="display: block; width: 100%; margin: 10px 0 10px 15px; color: #666;">
                {{ $data['translation'][232] }} {{ $data['copyright'] }}
                {{ $data['translation'][218] }}
            </div>
        </div>
    </div>
@endsection
