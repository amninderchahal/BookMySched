@extends('appointment.default')

@section('appointment-content')
<div class="page-header">
    <h3 id="header-title" class="w3-center">{{$employee['firstname'].' '.$employee['lastname']}} - Appointments</h3>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/fullcalendar.min.css') }}">
<link rel="stylesheet" media="print" href="{{ asset('css/fullcalendar.print.min.css') }}">
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar.min.js') }}"></script>

<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.timepicker.css') }}">
<script src="{{ asset('js/jquery.timepicker.min.js') }}" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('css/auto-complete.css') }}">
<script src="{{ asset('js/auto-complete.min.js') }}" type="text/javascript"></script>

<link rel="stylesheet" href="{{ asset('css/MonthPicker.min.css') }}">
<script src="{{ asset('js/MonthPicker.min.js') }}"></script>

<div class="col-md-11 float-center">
                <div class="full-calendar-div w3-margin-bottom">
                    <img id="loading-icon" class="" src="{{ asset('css/images/loading_icon.gif') }}" />
                    <div id="full-calender"></div>
                </div>
                <!--Modal-->
                <div class="modal fade" id="appointmentModal" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content form-inline">
                    <div class="modal-header">
                      <button type="button" class="close w3-large" data-dismiss="modal">&times;</button>
                      <h5 class="modal-title">Appointment Details</h5>
                    </div>
                    <div id="modalElement" class="modal-body"></div>
                    <div class="modal-footer">
                        <button id="appointment-edit-btn" type="button" class="btn btn-default pull-left">Edit</button>
                        <a id="delete-btn" class="btn btn-danger schedule-tools" href="" >Delete</a>
                        <button id="appointment-save-btn" type="button" class="btn btn-primary schedule-tools">Save</button>
                    </div>
                  </div>
                 </div>
                </div><!--Modal ends here-->
</div>
<script type="text/babel">
class Modal extends React.Component{
    callback(){
        $('#appointmentModal').modal();
        let currentDay = moment(this.props.event.date).day();
        let schedule = {!!$schedule!!};
        let disabledTimeRanges = [];
        schedule.map(function(daily){
            if(daily.day_of_week==currentDay){
                let end_time = moment.utc(daily.end_time,'h:mma').add(1,'minutes').format('h:mma');
                disabledTimeRanges = [
                    ['12am', daily.start_time],
                    [end_time, '11:59pm']
                ];
            }
        });
        let clickedDay = this.props.event.date;
        let that = this;
        data.appointments.map(function(event){
          if(clickedDay===event.date){
            if(that.props.event.id!=event.id){
              disabledTimeRanges.push(event.disabledTime);
            }
          }
        });
        $('.timepicker').timepicker('remove');
        $('.timepicker').timepicker({
            'disableTimeRanges': disabledTimeRanges,
            'step': 15
        });
        $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
        $('#client-id').val(this.props.event.client_id);
        let deleteUrl = '/appointment/organization/'+this.props.event.organization_id +'/'+this.props.event.employee_id+'/delete/'+this.props.event.id;
        $('#delete-btn').attr('href', deleteUrl);
        $('#date').val(this.props.event.date);
        let xhr;
        let xhr2;

        let clients;
        let services;
        let clientName = new autoComplete({
            selector: '#client-textbox',
            minChars:1,
            source: function(term, response){
                try { xhr.abort(); } catch(e){}
                xhr = $.getJSON("/client/"+that.props.event.organization_id,
                        { keyword: term },
                        function(data){
                            clients = data;
                            let names = data.map(function(client){
                                return(client.firstname+" "+client.lastname);
                            });
                            response(names);
                        });
                },
            onSelect:function(event, term, item){
                for(let client of clients){
                    let name = client.firstname+" "+client.lastname;
                    if(name===term){
                        $('#client-id').val(client.id);
                        break;
                    }
                }
            }
        });

        let serviceName = new autoComplete({
            selector: '#service-textbox',
            minChars:1,
            source: function(term, response){
                try { xhr2.abort(); } catch(e){}
                xhr2 = $.getJSON("/service/get/"+that.props.event.organization_id,
                        { keyword: term },
                        function(data){
                            services = data;
                            let names = data.map(function(service){
                                return(service.name);
                            });
                            response(names);
                        });
                },
            onSelect:function(event, term, item){
                for(let service of services){
                    if(service.name===term){
                        $('#service-id').val(service.id);
                        break;
                    }
                }
            }
        });
    }
    componentDidMount(){
        this.callback();
    }
    componentDidUpdate(){
        this.callback();
    }
    renderEditable(event, edit_mode){
           if(!edit_mode)
               return (<div className="row w3-margin modal-body">
                            <div className="modal-data-div col-xs-12 col-sm-6"><label>Title:</label> {event.title}</div>
                            <div className="modal-data-div col-xs-12 col-sm-6"><label>Client:</label> {event.client}</div>
                            <div className="modal-data-div col-xs-12 col-sm-12"><label>Service:</label> {event.service}</div>
                            <div className="modal-data-div col-xs-12 col-sm-12"><label>Date:</label> {event.date}</div>
                            <div className="modal-data-div col-xs-12 col-sm-6"><label>Start Time:</label> {event.startTime}</div>
                            <div className="modal-data-div col-xs-12 col-sm-6"><label>End Time:</label> {event.endTime}</div>
                            <div className="modal-data-div col-xs-12 col-sm-12"><label>Marked as:</label> {event.markedAs}</div>
                      </div>)
           else
               return (<form id="appointment-form" className="row w3-margin modal-body timepickerElement" action={this.props.actionUrl} method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <div className="modal-data-div col-xs-12 col-sm-6">
                                <label htmlFor="title-textbox">Title:</label> <input type="text" id="title-textbox" className="form-control" name="title" defaultValue={event.title} required />
                            </div>
                            <div className="modal-data-div col-sm-6 col-xs-12">
                                <label htmlFor="client-textbox">Client:</label> <input type="text" id="client-textbox" className="form-control" name="client" defaultValue={event.client} required /><input type="hidden" id="client-id" name="client_id" />
                            </div>
                            <div className="modal-data-div col-xs-12">
                                <label htmlFor="service-textbox">Service:</label> <input type="text" id="service-textbox" className="form-control" name="service" defaultValue={event.service} required /><input type="hidden" id="service-id" name="service_id" defaultValue={event.service_id} />
                            </div>
                            <div className="modal-data-div col-xs-12">
                                <label htmlFor="date">Date:</label> <input id="date" type="text" className="form-control datepicker" name="date" required />
                            </div>
                            <div className="modal-data-div col-sm-6 col-xs-12">
                                <label htmlFor="start_time">Start Time:</label> <input id="start_time" type="text" className="form-control timepicker" name="start_time" defaultValue={event.startTime} required />
                            </div>
                            <div className="modal-data-div col-sm-6 col-xs-12">
                                <label htmlFor="end_time">End Time:</label> <input id="end_time" type="text" className="form-control timepicker" name="end_time" defaultValue={event.endTime} required />
                            </div>
                            <div className="modal-data-div col-sm-12 col-xs-12">
                                <label htmlFor="marked_as">Marked As: </label>
                                <select className="form-control" id="marked_as" name="marked_as" defaultValue={event.marked_as} required>
                                    <option value="0">Not Completed</option>
                                    <option value="1">Completed</option>
                                    <option value="2">Cancelled</option>
                                </select>
                            </div>
                      </form>)
    }
    render(){
        return(this.renderEditable(this.props.event, this.props.edit_mode))
    }
}

function renderModal(event, edit_mode, update_mode){
    let actionUrl;
    if(update_mode){
        $(' #appointment-edit-btn').show();
        actionUrl = window.location.href+"/"+event.id;
     }
     else{
        $('#delete-btn,#appointment-edit-btn').hide();
        actionUrl = window.location.href+"/add/new";
     }
     ReactDOM.render(<Modal edit_mode={edit_mode} actionUrl={actionUrl} event={event} />, document.getElementById('modalElement'));
}

let eventGlobal = null;
let update_mode = false;

function checkMarkedAs(appointment){
  let obj = {};
  if(appointment.marked_as==0){
    obj.markedAs = "Not Completed"
    obj.color = "#3a87ad";
  }
  else if(appointment.marked_as==1){
    obj.markedAs = "Completed"
    obj.color = "#00b359";
  }
  else{
    obj.markedAs = "Cancelled"
    obj.color = "#ff4d4d";
  }
  return obj;
}

function createAppointments(data){
  let appointments = data.appointments.map(function(appointment){
      let markedAsObj = checkMarkedAs(appointment);
      let obj = appointment;
      obj.url = "/"+appointment.id;
      obj.start = appointment.date+"T"+appointment.start_time;
      obj.end = appointment.date+"T"+appointment.end_time;
      obj.marked_as = appointment.marked_as;
      obj.color = markedAsObj.color;
      obj.markedAs = markedAsObj.markedAs;
      obj.disabledTime = [appointment.start_time, appointment.end_time];
      return obj;
  });
  return appointments;
}
function checkDate(date){
    let today = moment().format("YYYY-MM-DD");
    if(moment(date).isBefore(today)){
      return true;
    }
    else
      return false;
}

function initialize(data){
    let organization_id = data.employee.organization_id;
    let appointments = createAppointments(data);

		$('#full-calender').fullCalendar({
            eventClick: function(event, jsEvent, view) {
                jsEvent.preventDefault();
                eventGlobal = event;
                update_mode = true;
                $("#appointment-edit-btn").text('Edit');
                $('.schedule-tools').hide();
                let clickedDay = moment(event.date).format("YYYY-MM-DD");
                if (checkDate(clickedDay)){
                  update_mode = false;
                  $("#appointment-edit-btn").hide();
                }
                renderModal(event, false, update_mode);
            },
            dayClick: function(date, jsEvent, view) {
                let clickedDay = date.format("YYYY-MM-DD");
                if (checkDate(clickedDay)){
                  return;
                }
                let obj={
                    'title' : "",
                    'service' : "",
                    'organization_id' : organization_id,
                    'service_id' : 1,
                    'client' : "",
                    'client_id' : 1,
                    'date' : clickedDay,
                    'startTime' : "",
                    'endTime' : "",
                    'url' : "/add"
                };
                eventGlobal = obj;
                update_mode = false;
                $("#appointment-edit-btn").text('Cancel');
                $('.schedule-tools').show();
                renderModal(obj, true, update_mode);
            },
			header: {
        left:'',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listMonth'
			},
			navLinks: true,
			editable: false,
			eventLimit: true,
			events: appointments
		});
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
let data = {!!$appointments!!};

$(document).ready(function() {
        initialize(data);

        let monthPicker = `<form class="appointment-month-form" method="post">
                                    <p class="txtbox-label">Select Month: </p>
                                    <input class="txtbox monthpicker" type="text" />
                            </form>`;

        $('.fc-left').html(monthPicker);
        $('#appointment-edit-btn').click(function(){
                let text = $(this).text();
                if (text=='Edit'){
                   renderModal(eventGlobal, true, update_mode);
                   $('.schedule-tools').fadeIn(400);
                   $(this).text('Cancel');
                }
                else{
                   renderModal(eventGlobal, false, update_mode);
                   $('.schedule-tools').fadeOut(400);
                   $(this).text('Edit');
                }
        });

        $('#appointment-save-btn').click(function(){
            $("#appointment-form").append('<input style="display:none;" type="submit" value="" />');
            $("#appointment-form>input[type=submit]").click();
        });

        function onDateSelect(selectedDate, id, renderSearchResult){
            let date = moment(selectedDate).format('YYYY-MM-DD');
            $('.fc-view-container').addClass('loading');
            $('#loading-icon').show();
            $.getJSON(
              window.location.href,
              {date:date, ajax:true},
              function(response){
                  data = response;
                  let appointments = createAppointments(response);
                  $('#full-calender').fullCalendar('removeEvents');
                  $('#full-calender').fullCalendar('addEventSource', appointments);
                  $('#full-calender').fullCalendar('rerenderEvents');
                  $('#full-calender').fullCalendar('gotoDate', date);
                  $('.fc-view-container').removeClass('loading');
                  $('#loading-icon').hide();

                  if(renderSearchResult){
                    appointments.map(function(appointment){
                        if(appointment.id == id){console.log('working');
                          let markedAsObj = checkMarkedAs(appointment);
                          let obj = appointment;
                          obj.url = "/"+appointment.id;
                          obj.start = appointment.date+"T"+appointment.start_time;
                          obj.end = appointment.date+"T"+appointment.end_time;
                          obj.marked_as = appointment.marked_as;
                          obj.color = markedAsObj.color;
                          obj.markedAs = markedAsObj.markedAs;
                          obj.disabledTime = [appointment.start_time, appointment.end_time];
                          renderModal(obj, false, false);
                        }
                    });
                  }
              }
            );
        }
        $(".monthpicker").MonthPicker({
          Button: false,
          MonthFormat: "yy-mm",
          OnAfterChooseMonth: onDateSelect
        });

        function getIndexOfSubString(string, substring){
            return string.search(substring);
        }
        let href = window.location.href;
        if(href.includes('&n=')){
          let idIndex = getIndexOfSubString(href, "n=");
          let id = href.slice(idIndex+2);
          let dateIndex = getIndexOfSubString(href, "d=");
          let date = href.slice(dateIndex+2, dateIndex+12);
          onDateSelect(date, id, true);
        }
	});
</script>
@endsection
