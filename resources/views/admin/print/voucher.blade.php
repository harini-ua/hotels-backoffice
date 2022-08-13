@extends('admin.layouts.print.blank')

@section('subject', $data['translation'][1225])

@section('content')
    <table width="100%" style="width: 610px;">
        <tr>
            <td align="left" style="padding-left: 15px;">
                <span style="font-weight: bold; font-size: 14px; width: 100%; float: left; color: #333;">
                    {{ $data['translation'][1225] }}
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
    </table>
    <div style="font-weight: bold; color: #ff0000; text-align: center;">
        {{ $data['translation'][239] }}
    </div>
    <div @if($data['provider_name'] === 'miki')
             style="font-weight: bold; text-align: center; font-size: 13px; color: #666;">
        {{ __('Booked and payable by Miki Travel Limited') }}
    </div @endif>
    <div style="margin: 10px 0 10px 15px;">
        {{ $data['translation'][230] }} {{ htmlspecialchars($data['booking_username']) }}
    </div>
    <div style="margin:10px 0 10px 15px; font-weight:bold; color:#333;">
        <u>{{ $data['translation'][194] }} {{ $data['booking_number'] }}</u>
    </div>
    <div>
        <table width="600" border="0">
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][224] }}:
                </td>
                <td style="padding-left: 15px;">{{ htmlspecialchars(implode(', ', $data['guests'])) }}</td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][217] }}:
                </td>
                <td style="padding-left: 15px;">{{ $data['hotel_name'] }}</td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px">
                    {{ $data['translation'][222] }}:
                </td>
                <td style="padding-left: 15px;">{{ $data['hotel_address'] }}</td>
            </tr>
            <tr style="font-size:13px;color:#666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][228] }}:
                </td>
                <td style="padding-left: 15px;">{{ $data['booking_email'] }}</td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][244] }}:
                </td>
                <td style="padding-left: 15px;">{{ $data['booking_checkin'] }}</td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][229] }}:
                </td>
                <td style="padding-left: 15px;">{{ $data['booking_checkout'] }}</td>
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
            <tr @if(count($data['children_ages']))
                    style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][1261] }}:
                </td>
                <td style="padding-left: 15px;">{{ implode(', ', $data['children_ages']) }}</td>
            </tr @endif>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][208] }}:
                </td>
                <td style="padding-left: 15px;">
                    {{ $data['translation'][1226] }}
                </td>
            </tr>
            @if($data['provider_name'] === 'hotelbed')
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][985] }}:
                </td>
                <td style="padding-left: 15px;">{{ $data['supplier_name'] }}</td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][986] }}:
                </td>
                <td style="padding-left: 15px;">{{ $data['vat_number'] }}</td>
            </tr>
            <tr style="font-size: 13px; color: #666;">
                <td style="white-space: nowrap; vertical-align: top; padding-left: 15px;">
                    {{ $data['translation'][207] }}:
                </td>
                <td style="padding-left: 15px;">{{ $data['booking_number'] }}</td>
            </tr>
            @endif
        </table>
    </div>
    <div style="margin: 10px 0 10px 15px; font-weight: bold; color: #333;">
        <u>{{ $data['translation'][247] }}:</u>
    </div>
    <div style="margin: 5px 15px 10px 15px; font-size: 13px; color: #666;">
        {{ $data['translation'][200] }}
    </div>
    @if($data['remark'])
    <div style="margin: 10px 0 10px 15px; font-weight: bold; color: #333;">
        <u>{{ $data['translation'][987] }}:</u>
    </div>
    <div class="message_box_success" style="margin: 5px 15px 10px 15px; font-size: 13px; color: #666;">
        {{ $data['remark'] }}
    </div>
    @endif
    @if($result['show_all_booking_non_refund'])
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
                <a style="color: #0080C0" href="{{ $result['cancel_booking_url'] }}"> {{ $data['translation'][236] }}</a>
            </div>
        @endif
    @endif
    @if($data['customer_support'] !== null)
    <div style="margin:10px 0 10px 15px;font-weight:bold;color:#333;">
        <u>{{ $data['translation'][1238] }}:</u>
    </div>
    <div style="margin: 5px 15px 10px 15px; font-size: 13px; color :#666;">
        {{ $data['translation'][1053] }} {{ $data['customer_support']['country'] }}, {{ $data['translation'][1054] }} {{ $data['customer_support']['phone'] }}
        {{ $data['translation'][1055] }} {{ $data['customer_support']['work_hours'] }} {{ $data['translation'][1056] }}
    </div>
    @endif
    <div style="margin: 10px 0 10px 15px; font-weight: bold; color: #333;">
        <u>{{ $data['translation'][1057] }}:</u>
    </div>
    <div style="margin: 5px 0 10px 15px; font-size: 13px; color: #666;">
        {{ $data['translation'][1058] }} {{ $data['provider_support_phone'] }}
    </div>
    @if($data['show_extra_benefits'])
        <div style="margin: 10px 15px 10px 15px; font-weight: bold; color: #333;">
            <u>{{ __('Sport, concert, and show tickets') }}:</u>
        </div>
        <div style="margin: 5px 15px 10px 15px; font-size: 13px; color:#666;">
            {{ __('Make your stay more memorable by attending a concert or a sporting event.') }}
        </div>
        <div style="margin: 5px 15px 10px 15px; font-size: 13px; color: #666;">
            {{ __('Soccer matches (All major leagues, incl. Premier League, La Liga and Champions League),') }}
            {{ __('Concerts, Shows, Formula 1, Tennis ,etc') }}
        </div>
        <div style='margin: 5px 15px 5px 15px; font-size: 13px; color: #666;'>
            {{ __('Having done a booking with us you are ') }}
            {{ __('qualified to receive 5% discount on all tickets from our partner Sports Events 365 ') }}
            (<a href='http://hei.tickets-partners.com/'>http://hei.tickets-partners.com/</a>)
            {{ __('The discount is already deducted from the prices you see.') }}
        </div>
    @endif
    <div style="border-top: 1px solid #ccc;">
        <div style="display: block; width: 100%; margin: 10px 0 10px 15px; color: #666;">
            {{ $data['translation'][232] }} {{ $data['copyright'] }}
            {{ $data['translation'][218] }}
        </div>
    </div>
@endsection
