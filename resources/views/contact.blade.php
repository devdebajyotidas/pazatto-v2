@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2"> </div>
            <div class="col-md-8 white-box m-t-30">
                <h1>Contact Us</h1>
                <p class="lead">Have a question or want further information?</p>

                <p>Fill in the short form and we will get back to you as soon as possible.</p> <br>

                <!-- BEGIN DOWNLOAD PANEL -->
                <div class="panel panel-default well">
                    <div class="panel-body">
                        <form action="" class="form-horizontal track-event-form bv-form" data-goaltype="”General”" data-formname="”ContactUs”" method="get" id="contact-us-all" novalidate="novalidate">
                            <input name="elqSiteId" type="hidden" value="928">
                            <input name="sFDCLastCampaignID" type="hidden" value="701400000012Lql">
                            <input name="elqFormName" type="hidden" value="EMEAAllContactUsSubmissions">
                            <input name="nexturl" type="hidden" value="">
                            <input name="Partner" type="hidden" value="">
                            <input name="language" type="hidden" value="en">

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter first name" name="C_FirstName" data-bv-field="C_FirstName">
                                    </div>
                                    <small data-bv-validator="notEmpty" data-bv-validator-for="C_FirstName" class="help-block" style="display: none;">Required</small></div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <input type="text" class="form-control" id="exampleInputLastName" placeholder="Enter last name" name="C_LastName" data-bv-field="C_LastName"></div>
                                    <small data-bv-validator="notEmpty" data-bv-validator-for="C_LastName" class="help-block" style="display: none;">Required</small></div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email" name="C_EmailAddress" data-bv-field="C_EmailAddress">
                                    </div>
                                    <small data-bv-validator="notEmpty" data-bv-validator-for="C_EmailAddress" class="help-block" style="display: none;">Required</small></div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input type="text" class="form-control" id="C_BusPhone" placeholder="Phone" name="C_BusPhone">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-comment fa-2"></i>
                                        </div>
                                        <textarea class="form-control" name="Comments" id="Comments" rows="5" style="width:99.9%" placeholder="Enter your message here"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button id="contacts-submit" type="submit" class="btn btn-default btn-info">CONTACT US</button>
                                </div>
                            </div>
                            <input type="hidden" value=""></form>
                    </div><!-- end panel-body -->
                </div><!-- end panel -->
                <!-- END DOWNLOAD PANEL -->
            </div><!-- end col-md-8 -->
            <div class="col-md-2"> </div>
        </div>
    </div>
@endsection