@extends('layouts.backend.heinz')

@section('content')
<div class="content">
    <div class="container">

        <div class="card-box table-responsive processing-container">
            <div class="row">
              <div class="card processing-card">
                <div class="card-content">
                  <h3>
                    Please wait, your running in the background and you will recieve notification once completed
                  </h3>
                  <h5>[ <span id="percentage">1</span> %]&nbsp; <span id="processing">Processing...</span> </h5>
                  <h6>Total file processed [ <span id="processed">1</span> ] out of [ <span id="total">1</span> ]</h6>
                </div>
              </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    var app = new Vue({
      el: '#heinz',
      data: {
        isRunning: true,
        percentage: 1,
        total: 1,
        processed: 1
      },
      methods: {
          checkProcess () {
            axios.get(`/api/v1/console/check_process_status`)
                .then(response => {
                  document.getElementById("percentage").innerHTML = response.data.data.percentage
                  document.getElementById("total").innerHTML = response.data.data.total
                  document.getElementById("processed").innerHTML = response.data.data.count

                  console.log(response.data.data.percentage);
                  if (document.getElementById("percentage").innerHTML == 100){
                    window.clearInterval(this.timer);
                    document.getElementById("processing").innerHTML = "Completed"
                    this.enableLinks()
                  }
                }).catch(error => console.error(error));

          },
          disableLinks() {
            var anchors = document.getElementsByTagName("a");
            for (var i = 0; i < anchors.length; i++) {
                anchors[i].onclick = function() {
                  alert("on going process...please wait till it's completed!")
                  return false;
                };
            }
          },
          enableLinks() {
            var anchors = document.getElementsByTagName("a");
            for (var i = 0; i < anchors.length; i++) {
                anchors[i].onclick = function() {
                  return true;
                };
            }
          }
      },
      computed: {
        timer: function () {
          var self = this
          return window.setInterval(function() {
            self.checkProcess()
          }, 1000);
        }
      },
      mounted() {
        this.timer
        this.disableLinks()

      }


    });
</script>
@endsection
