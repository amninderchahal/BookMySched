@extends('schedule.default')

@section('schedule-content')
<div class="page-header">
       <h3 class="w3-center">{{$employee['firstname']}} {{$employee['lastname']}} - Schedule</h3>
    </div>
<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                <form method="post">
                    @if($count>0)
                    {{csrf_field()}}
                    <div id="react-component" ></div>
                    <div id="schedule-btn-container" class="col-sm-12 w3-display-container">
                        <button type="button" id="schedule-edit-btn" class="btn btn-default">Edit</button>
                        <span id="days-dropdown" class="schedule-tools"></span>
                        <button type="submit" class="w3-display-bottomright btn btn-primary schedule-tools">Save</button>
                    </div>
                    @else
                    <div class="w3-center alert alert-success">
                      <strong>No Schedule found!</strong>
                    </div>
                    <div class="w3-margin-top">
                        <h5><a class="w3-text-indigo" href="{{$uri['add_uri']}}">Add schedule</a></h5>
                    </div>
                    @endif
                </form>
</div>
<script type="text/babel">
        class TextElement extends React.Component{
            render(){
                return(
                        <div className="schedule-row panel-body">
                             <span className="header-component col-xs-4" >{this.props.days[this.props.daily.day_of_week-1]}</span>
                             <span className="schedule-component data-span col-xs-4" >{this.props.daily.start_time}</span>
                             <span className="schedule-component data-span col-xs-4" >{this.props.daily.end_time}</span>
                        </div>
                );
            }
        }

        class InputElement extends React.Component{
            render(){
                return(
                        <div id="timepickerElement" className="schedule-row panel-body">
                             <span className="header-component col-xs-4" >{this.props.days[this.props.daily.day_of_week-1]}</span>
                             <span className="schedule-component data-span col-xs-4" >
                                   <input type="text" className="picktime txtbox schedule-textbox " name={'start_time'+this.props.daily.day_of_week} defaultValue={this.props.daily.start_time} required />
                             </span>
                             <span className="schedule-component data-span col-xs-4" >
                                   <input type="text" className="picktime txtbox schedule-textbox" name={'end_time'+this.props.daily.day_of_week} defaultValue={this.props.daily.end_time} required />
                                   <a href="#" className="day-remove-btn edit-component schedule-tools" data-toggle="tooltip" data-placement="bottom" title={"Remove "+this.props.days[this.props.daily.day_of_week-1]} onClick={()=>this.props.removeDay(this.props.index, true)}><span className="glyphicon text-danger glyphicon-remove"></span></a>
                             </span>
                        </div>
                );
            }
        }

        class Schedule extends React.Component{
            componentDidUpdate() {
                $('#timepickerElement .picktime').timepicker();
                $('[data-toggle="tooltip"]').tooltip();

                if(this.props.edit_mode)
                    $('.schedule-tools').fadeIn(500);
                else
                    $('.schedule-tools').fadeOut(500);
              }
            componentDidMount() {
                $('[data-toggle="tooltip"]').tooltip();
              }
            render() {
                const renderEditable = function(dailySchedule, index){

                    const days= ['Monday','Tuesday','Wednesday','Thursday', 'Friday', 'Saturday', 'Sunday'];
                    if(!this.props.edit_mode)
                         return (<TextElement key={index} removeDay={this.props.removeDay} index={index} days={days} daily={dailySchedule} />)

                    else
                         return (<InputElement key={index} removeDay={this.props.removeDay} index={index} days={days} daily={dailySchedule} />)
                };
                return (
                    <div id="schedule-react-element" className="outer form-inline panel panel-default">

                        <div className="panel-heading">
                             <h6 className="header-component schedule-component col-xs-4" >Day Of Week</h6>
                             <h6 className="schedule-component col-xs-4" >Start Time</h6>
                             <h6 className="schedule-component col-xs-4" >End Time</h6>
                        </div>
                        {this.props.schedule.sort((a, b)=>a.day_of_week > b.day_of_week).map(renderEditable.bind(this))}
                    </div>
                )
            }
        }

        let result = {!!$schedule!!};
        let organization_id=result.schedule[0]['organization_id'];
        let data = result.schedule;

        function removeDay(index, edit_mode){
            data.splice(index, 1);
            ReactDOM.render(<Schedule edit_mode ={edit_mode} removeDay={removeDay} schedule = {data} />, document.getElementById('react-component'));
        }

        function renderSchedule(edit_mode, data){
            ReactDOM.render(<Schedule edit_mode ={edit_mode} removeDay={removeDay} schedule = {data} />, document.getElementById('react-component'));
        }

        let addDay = function(day){
                           let obj = {
                                     "id": day,
                                     "employee_id": result.employee.id,
                                     "organization_id": organization_id,
                                     "day_of_week": day,
                                     "start_time": "",
                                     "end_time": ""
                                  };

                           data.splice(day-1, 0, obj);
                           renderSchedule(true, data);
                           renderSelect();
                        };

            class SelectDaysElement extends React.Component{
                render(){
                    const days= ['Monday','Tuesday','Wednesday','Thursday', 'Friday', 'Saturday', 'Sunday'];
                    const element = function(day){
                                 return (
                                    <li key={day}><a className="select-day-btn" onClick={()=>this.props.addDay(day)} href='#'>{days[day-1]}</a></li>
                                    );
                              };
                    return (
                        <span id="filter-dropdown" className="dropdown">
                            <button className="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Add a day <span className="caret"></span></button>
                            <ul className="dropdown-menu">
                              {this.props.days.map(element.bind(this))}
                            </ul>
                          </span>
                    );
                }
            }

            function renderSelect(){
                //Select days dropdown
                let daysTaken = data.map(function(day){
                    return day.day_of_week;
                });

                let daysAvailable = [];

                for(let i=1; i<=7; i++){
                    let num = $.inArray(i, daysTaken);
                    if(num == -1){
                        daysAvailable.push(i);
                    }
                }
                ReactDOM.render(<SelectDaysElement addDay={addDay} days={daysAvailable} />, document.getElementById('days-dropdown'));
            }

        $(document).ready(function(){
            renderSchedule(false, data);

            $('#schedule-edit-btn').click(function(){
                let text = $(this).text();
                if (text==='Edit'){
                   $('.data-span').hide().fadeIn(500);
                   renderSchedule(true, data);
                   $(this).text('Cancel');
                }
                else{
                   $('.data-span').hide().fadeIn(500);
                   renderSchedule(false, result.schedule);
                   renderSelect();
                   $(this).text('Edit');
                }
            });
            renderSelect();
        });
</script>
@endsection
