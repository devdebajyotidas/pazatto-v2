<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="sttabs tabs-style-iconbox">
            <nav>
                <ul>
                    @if($role=="admin")
                        <li @if($page=='dashboard') class="tab-current" @endif><a href="{{url('/dashboard')}}" class="sticon ti-home"><span>Dashboard</span></a></li>
                        <li @if($page=='orders') class="tab-current" @endif><a href="{{url('/orders')}}" class="sticon ti-pencil-alt"><span>Orders</span></a></li>
                        <li @if($page=='vendors') class="tab-current" @endif><a href="{{url('/vendors')}}" class="sticon fa fa-user"><span>Vendors</span></a></li>
                        <li @if($page=='customers') class="tab-current" @endif><a href="{{url('/customers')}}" class="sticon fa fa-users"><span>Customers</span></a></li>
                        <li @if($page=='services') class="tab-current" @endif><a href="{{url('/services')}}" class="sticon ti-pencil-alt"><span>Services</span></a></li>
                        {{--<li @if($page=='discounts') class="tab-current" @endif><a href="{{url('/discounts')}}" class="sticon ti-pencil-alt"><span>Discounts</span></a></li>--}}
                        <li @if($page=='reports') class="tab-current" @endif><a href="{{url('/reports')}}" class="sticon fa fa-line-chart"><span>Reports</span></a></li>
                        <li @if($page=='agents') class="tab-current" @endif><a href="{{url('/agents')}}" class="sticon fa fa-user-secret"><span>Agents</span></a></li>
{{--                        <li @if($page=='settings') class="tab-current" @endif><a href="{{url('/settings')}}" class="sticon ti-settings"><span>Settings</span></a></li>--}}
                    @endif

                    @if($role=="vendor")
                        <li @if($page=='dashboard') class="tab-current" @endif><a href="{{url('/dashboard')}}" class="sticon ti-home"><span>Dashboard</span></a></li>
                        <li @if($page=='orders') class="tab-current" @endif><a href="{{url('/orders')}}" class="sticon ti-light-bulb"><span>Orders</span></a></li>
                        <li @if($page=='menu') class="tab-current" @endif><a href="{{url('vendors/' . \Illuminate\Support\Facades\Auth::user()->account->id . '/items')}}" class="sticon ti-pencil-alt"><span>Menu</span></a></li>
                        <li @if($page=='reports' || $page =='sales-details' || $page == "deliveries-details") class="tab-current" @endif><a href="{{url('/reports')}}" class="sticon fa fa-line-chart"><span>Reports</span></a></li>
                    @endif

                    @if($role=="agent")
                        <li @if($page=='dashboard') class="tab-current" @endif><a href="{{url('/dashboard')}}" class="sticon ti-home"><span>Dashboard</span></a></li>
                        <li @if($page=='orders') class="tab-current" @endif><a href="{{url('/orders')}}" class="sticon ti-light-bulb"><span>Orders</span></a></li>
                            <li @if($page=='reports' || $page =='sales-details' || $page == "deliveries-details") class="tab-current" @endif><a href="{{url('/reports')}}" class="sticon fa fa-line-chart"><span>Reports</span></a></li>
                    @endif

                    @if($role=="operation")
                        <li @if($page=='orders') class="tab-current" @endif><a href="{{url('/orders')}}" class="sticon ti-light-bulb"><span>Orders</span></a></li>
                        <li @if($page=='vendors') class="tab-current" @endif><a href="{{url('/vendors')}}" class="sticon ti-pencil-alt"><span>Vendors</span></a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>