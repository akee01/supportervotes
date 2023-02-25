<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/morph.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>SV | Homepage</title>
</head>
<body class="bg-white">
<header class="container">
    <nav class="navbar navbar-expand-sm navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SV</a>
            <ul class="navbar-nav ms-auto flex-row">
                <li class="nav-item me-2">
                    <a class="nav-link" href="#">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="#">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<section class="main-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-center">
                    <img src="https://i.pravatar.cc/70" class="rounded-circle" alt=""
                         style="width: 80px;height: 80px;">
                    <div class="ms-3">
                        <p class="fw-bold mb-0 lh-1">Amalia Sukhao</p>
                        <span class="text-muted small">Creator</span>
                        <p class="small mb-0">139 Premium Votes</p>
                    </div>
                </div>
                <p class="text-center small text-muted mt-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut consequatur cupiditate delectus ex iste laborum natus sed voluptatem. Dolores incidunt nulla voluptatum? Consequuntur cum deleniti doloremque enim mollitia odit, quis.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto at atque commodi consectetur dicta dolorem, ducimus eligendi esse et excepturi fugit iusto, laborum minus nemo pariatur quas rem rerum! Iure?</p>
                <h4 class="text-center mb-4">Total Money from Donations: 45 USD</h4>
                <div class="card card-body p-4 bg-light border-0 mb-3">
                    <h3 class="h5 mb-4 text-primary">Which of these songs do you prefer?
                        <button class="btn btn-primary float-end btn-sm"><i class="fa fa-share"></i></button>
                    </h3>
                    <ul class="answers list-group mb-3">
                        <li style="background: linear-gradient(to right, #2e86a6 51%, #ffffff 51%);" href="#" class="list-group-item mb-2 rounded">Dusk Till Down - Sia <span class="float-end">51%</span></>
                        <li style="background: linear-gradient(to right, #88c1d7 20%, #ffffff 20%);" href="#" class="list-group-item mb-2 rounded">Dusk Till Down - Sia <span class="float-end">20%</span></li>
                        <li style="background: linear-gradient(to right, #88c1d7 29%, #ffffff 29%);" href="#" class="list-group-item mb-2 rounded">Dusk Till Down - Sia <span class="float-end">29%</span></li>
                    </ul>
                    <div class="d-flex justify-content-between align-items-end mb-3">
                        <div>
                            <div class="text-muted small"><b>Poll ends at: </b>12 Dec 2023 at 10:15 PM</div>
                        </div>
                        <p class="mb-0 small">35 Votes</p>
                    </div>

                    <div class="d-flex justify-content-between align-items-end">
                        <div>
                            Top premium Voter: Adam Jones <br>
                            <span class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</span>
                        </div>
                        <a href="#" class="mb-0 small text-muted">See all comments</a>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-danger me-3">Delete Poll</button>
                    <button class="btn btn-primary">Finalize Poll</button>
                </div>
            </div>
        </div>
    </div>
</section>
<footer class="bg-light p-4">
    <div class="text-center">&copy; Copyrights 2023, All Rights Reserved.</div>
</footer>

<div class="modal fade" id="cancel-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-5 text-center">
                <p>Proceed with cancelling this poll? All changes will be lost!</p>
                <div>
                    <button class="btn btn-outline-primary px-4">No</button>
                    <button class="btn btn-primary px-4 mx-2">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script>
    $(document).on('click','.add-option',e=>{
        $('.option-elements').append($('.option-elem:first').clone().find('input').val('').parent());
    })

    $(document).on('click','.remove-option',e=>{
        if ($('.option-elements .option-elem').length > 1){
            $(e.target).closest('.option-elem').remove();
        }
    })
</script>
</body>
</html>