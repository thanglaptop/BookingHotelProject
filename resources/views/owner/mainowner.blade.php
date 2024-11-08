<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGOBEE</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    <!-- css owner -->
    @vite('resources/css/owner.css')

    <!-- css bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- icon bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css"
        rel="stylesheet">
</head>

<body>
    @include('owner/header')


    <section class="noidung">
        <div class="container p-4">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="QLKS" role="tabpanel" aria-labelledby="QLKS-tab"
                    tabindex="0">

                    @include('owner/mainownercontent/displayhotel')

                    @include('owner/mainownercontent/addhotel')
                </div>


                <div class="tab-pane fade" id="TTTT" role="tabpanel" aria-labelledby="TTTT-tab" tabindex="0">
                    @include('owner/mainownercontent/pminfo')
                </div>

                <div class="tab-pane fade" id="TTCN" role="tabpanel" aria-labelledby="TTCN-tab" tabindex="0">
                    <h1>Thông tin cá nhân sẽ ở đây</h1>
                </div>

                <div class="tab-pane fade" id="DT" role="tabpanel" aria-labelledby="DT-tab" tabindex="0">
                    <h1>Doanh thu sẽ ở đây</h1>
                </div>




                <div class="tab-pane fade" id="DG" role="tabpanel" aria-labelledby="DG-tab" tabindex="0">
                    <h1>Đánh giá sẽ ở đây</h1>
                </div>
            </div>
        </div>
    </section>

    @vite('resources/js/owner.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
