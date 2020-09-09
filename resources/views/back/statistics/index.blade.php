@extends('back.layout') 

@section('main') 

  <div class="container-fluid">    

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label for="customRange1">Année : &nbsp</label>
            @foreach ($years as $year)
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="{{ $year }}" name="year" class="custom-control-input" value="{{ $year }}" @if($actualYear == $year) checked @endif>
                <label class="custom-control-label" for="{{ $year }}">{{ $year }}</label>
              </div>               
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div id="ordersChart" style="height: 300px;" class="card-body">          
        </div>
        <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
        <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
        <script>
          const OrdersChart = new Chartisan({
            el: '#ordersChart',
            url: "@chart('orders_chart')" + '?year={{ $actualYear }}',
            hooks: new ChartisanHooks()
              .colors(['#c33'])
              .responsive()
              .beginAtZero()
          });
        </script>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div id="usersChart" style="height: 300px;" class="card-body">          
        </div>
        <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
        <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
        <script>
          const UsersChart = new Chartisan({
            el: '#usersChart',
            url: "@chart('users_chart')" + '?year={{ $actualYear }}',
            hooks: new ChartisanHooks()
              .colors(['#3c3'])
              .responsive()
              .beginAtZero()
          });
        </script>
      </div>
    </div>

  </div>

@endsection

@section('js')
  <script>
    $('input').change(function() { 
      let year = $("input[name='year']:checked").val();
      let param = '?year=' + year;;     
      OrdersChart.update({
        url: "@chart('orders_chart')" + param
      });
      UsersChart.update({
        url: "@chart('users_chart')" + param
      });
      window.history.replaceState('', '', '/admin/statistiques/' + year);
    });
  </script>
@endsection