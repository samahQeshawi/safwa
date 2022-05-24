{{-- Extends layout --}}
@extends('web._default')

{{-- Content --}}
@section('content')

    <div class="site-inner-wrapper">

        @include('web.layout.base._subheader')


      <div class="site-inner-content our-branches-inner-content">

        <div class="container">

          <div class="row">

            <div class="col-lg-4">

              <div class="branches-col-left">
				<h5>فروع المنطقة الوسطى</h5>

                <p>مخرج 28 - طريق الدائري الغربي مخرج 28 بجوار مطاعم الرومنسية</p>
                <p>وادي لبن- مخرج 34ش الطائف بجوار اشارة نادي الرياض</p>
                <p>العزيزية - شارع عرفات بجوار الدفاع المدني</p>
				<p>الخالدية- طريق الخرج بدايه بجوار كبري شركة هواندا</p>
				<p>السلي - ش ابو عبيد عامر بن حراج</p>
				<p>العليا - شارع العليا العام مقابل مكتبة الملك فهد</p>
			    <p>الدائري الشرقي - مخرج 10 مقابل متحف الطيران المدني</p>
				<p>مخرج 25 - الطريق الدائري الغربي </p>

              </div>

            </div>

            <div class="col-lg-8">

              <div class="branches-col-right">

				<iframe src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=Riyadh&amp;t=&amp;z=9&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"  frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-lg-4">

              <div class="branches-col-left">

                <h5>فروع المنطقة الغربية</h5>

                <p>التحلية1 - حي العزيزية - شارع التحلية </p>
                <p>التحلية 2- شارع السبعين مع التحلية</p>
                <p>فلسطين - حي السلامة طريق المدينة </p>
				<p>البغدادية - طريق المدينة امام سنتر سيتي ماكس</p>
                <p>الجامعة - شارع الجامعة مع طريق مكة </p>
                <p>السبعين - حي النزهة شارع الامير ماجد</p>


              </div>

            </div>

            <div class="col-lg-8">

              <div class="branches-col-right">

                <iframe src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=Jiddha&amp;t=&amp;z=9&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"  frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

              </div>

            </div>

          </div>

          <div class="row">

            <div class="col-lg-4">

              <div class="branches-col-left">

                <h5>فروع المنطقة الشرقية </h5>

                <p>الخبر - مكتب العزيزية - مخرح جسر البحرين طريق مجلس التعاون</p>

                <p>الدمام - مكتب الزهرة - حي الزهور شارع 18 </p>

                <p>الاحساء - حي المزروعية </p>


              </div>

            </div>

            <div class="col-lg-8">

              <div class="branches-col-right">

                <iframe src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=Damam&amp;t=&amp;z=10&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"  frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

              </div>

            </div>

          </div>
        </div>

      </div>

    </div>




@endsection

{{-- Scripts Section --}}
@section('scripts')

    <script>

    </script>
@endsection
