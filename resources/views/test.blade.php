@extends('layouts.main')

@section('main-container')

  <div class="container">
    <div class="row">
      <div class="col-xs-offset-2 col-xs-8 col-lg-offset-3 col-lg-6">
        <div class="well details">
          <div class="col-sm-12">
            <div class="col-xs-12 col-sm-8">
              <h2 style="text-decoration:underline;">Andrew Smith</h2>
              <p><strong>Position: </strong>Senior Developer </p>
              <p><strong>Current Company: </strong>Semantics </p>
              <p><strong>Department: </strong>Data Visualization </p>
              <p class="text-center skills"><strong>Skills</strong></p>
              <div class="skillLine"><div class="skill pull-left">HTML5</div><div class="rating" id="rate1"></div></div>
              <div class="skillLine"><div class="skill pull-left">C#</div><div class="rating" id="rate2"></div></div>
              <div class="skillLine"><div class="skill pull-left">jQuery</div><div class="rating" id="rate3"></div></div>
              <div class="skillLine"><div class="skill pull-left">SQL</div><div class="rating" id="rate4"></div></div>
              <div class="skillLine"><div class="skill pull-left">CSS</div><div class="rating" id="rate5"></div></div>
            </div>
            <div class="col-xs-12 col-sm-4 col-lg-1 text-center">
              <figure>
                <span class="fa fa-file-text-o" style="font-size:127px; padding-top: 20px;"></span>
                <span style="font-size:47px; padding-top: 20px;">Avg.</span>
                <span class="avg">6.2</span>
              </figure>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    body {
      font-family: "Segoe UI", 'sans-serif';
    }

    .avg {
      font-size:77px;
      padding-top: 20px;
      color:#5CB85C;
    }

    .details {
      min-height: 355px;
      display: inline-block;
    }

    .rating {
      padding-left:40px;
    }

    .skillLine {
      display:inline-block;
      width:100%;
      padding: 3px 4px;
    }

    .skills {
      text-decoration:underline;
    }

    div.skill {
      background: #F58723;
      border-radius: 3px;
      color: white;
      font-weight: bold;
      padding: 3px 4px;
      width:70px;
    }
  </style>

  <!-- you need to include the shieldui css and js assets in order for the charts to work -->
  <link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/shieldui-all.min.css" />
  <link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
  <script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>

  <script type="text/javascript">
    jQuery(function ($) {
      $('#rate1').shieldRating({
        max: 7,
        step: 0.1,
        value: 6.3,
        markPreset: false
      });
      $('#rate2').shieldRating({
        max: 7,
        step: 0.1,
        value: 6,
        markPreset: false
      });
      $('#rate3').shieldRating({
        max: 7,
        step: 0.1,
        value: 3,
        markPreset: false
      });
      $('#rate4').shieldRating({
        max: 7,
        step: 0.1,
        value: 5,
        markPreset: false
      });
      $('#rate5').shieldRating({
        max: 7,
        step: 0.1,
        value: 5.7,
        markPreset: false
      });
    });
  </script>
@endsection