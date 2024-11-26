@extends('user.layouts.master')

@section('main-content')
<div class="container-fluid">
  @include('user.layouts.notification')
  
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Bookings</h1>
  </div>

  <div class="row">
    @php
          $bookings = DB::table('bookings')->paginate(10); 
      @endphp
    <div class="col-xl-12 col-lg-12">
      <table class="table table-bordered" id="booking-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>S.N.</th>
            <th>Booking No.</th>
            <th>Date</th>
            <th>Time</th>
            <th>Purpose</th>
            <th>Room No.</th>
            <th>Phone Number</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>S.N.</th>
            <th>Booking No.</th>
            <th>Date</th>
            <th>Time</th>
            <th>Purpose</th>
            <th>Room No.</th>
            <th>Phone Number</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </tfoot>
        <tbody>
          @if($bookings->count() > 0)
            @foreach($bookings as $booking)   
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $booking->booking_number ?? 'N/A' }}</td>
                  <td>{{ $booking->booking_date }}</td>
                  <td>{{ $booking->booking_time }}</td>
                  <td>{{ $booking->purpose }}</td>
                  <td>{{ $booking->no_room }}</td>
                  <td>{{ $booking->phone_number }}</td>
                  <td>
                      @if($booking->status == 'pending')
                        <span class="badge badge-warning">{{ ucfirst($booking->status) }}</span>
                      @elseif($booking->status == 'approved')
                        <span class="badge badge-success">{{ ucfirst($booking->status) }}</span>
                      @else
                        <span class="badge badge-danger">{{ ucfirst($booking->status) }}</span>
                      @endif
                  </td>
                  <td>
                      <a href="{{ route('user.booking.show', $booking->id) }}" class="btn btn-warning btn-sm" style="height:30px; width:30px; border-radius:50%" data-toggle="tooltip" title="View" data-placement="bottom"><i class="fas fa-eye"></i></a>
                      <form method="POST" action="{{ route('user.booking.delete', $booking->id) }}" style="display:inline;">
                        @csrf 
                        @method('delete')
                        <button class="btn btn-danger btn-sm" style="height:30px; width:30px; border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                      </form>
                  </td>
              </tr>  
            @endforeach
          @else
              <tr>
                  <td colspan="9" class="text-center"><h4 class="my-4">You have no bookings yet!! Please create a new booking</h4></td>
              </tr>
          @endif
        </tbody>
      </table>

      {{ $bookings->links() }}
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script type="text/javascript">
  const url = "{{ route('user.booking.Chart') }}"; // Update to match route for incomeChart

  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }

  // Area Chart Example
  var ctx = document.getElementById("myAreaChart");

  axios.get(url)
      .then(function (response) {
          const data_keys = Object.keys(response.data);
          const data_values = Object.values(response.data);

          var myLineChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: data_keys,
                  datasets: [{
                      label: "Income",
                      lineTension: 0.3,
                      backgroundColor: "rgba(78, 115, 223, 0.05)",
                      borderColor: "rgba(78, 115, 223, 1)",
                      pointRadius: 3,
                      pointBackgroundColor: "rgba(78, 115, 223, 1)",
                      pointBorderColor: "rgba(78, 115, 223, 1)",
                      pointHoverRadius: 3,
                      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                      pointHitRadius: 10,
                      pointBorderWidth: 2,
                      data: data_values,
                  }],
              },
              options: {
                  maintainAspectRatio: false,
                  layout: {
                      padding: {
                          left: 10,
                          right: 25,
                          top: 25,
                          bottom: 0
                      }
                  },
                  scales: {
                      xAxes: [{
                          time: {
                              unit: 'date'
                          },
                          gridLines: {
                              display: false,
                              drawBorder: false
                          },
                          ticks: {
                              maxTicksLimit: 7
                          }
                      }],
                      yAxes: [{
                          ticks: {
                              maxTicksLimit: 5,
                              padding: 10,
                              callback: function(value) {
                                  return '$' + number_format(value);
                              }
                          },
                          gridLines: {
                              color: "rgb(234, 236, 244)",
                              zeroLineColor: "rgb(234, 236, 244)",
                              drawBorder: false,
                              borderDash: [2],
                              zeroLineBorderDash: [2]
                          }
                      }],
                  },
                  legend: {
                      display: false
                  },
                  tooltips: {
                      backgroundColor: "rgb(255,255,255)",
                      bodyFontColor: "#858796",
                      titleMarginBottom: 10,
                      titleFontColor: '#6e707e',
                      titleFontSize: 14,
                      borderColor: '#dddfeb',
                      borderWidth: 1,
                      xPadding: 15,
                      yPadding: 15,
                      displayColors: false,
                      intersect: false,
                      mode: 'index',
                      caretPadding: 10,
                      callbacks: {
                          label: function(tooltipItem, chart) {
                              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                              return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                          }
                      }
                  }
              }
          });
      })
      .catch(function (error) {
          console.log(error);
      });
</script>
@endpush
