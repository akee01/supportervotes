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
                <div class="text-center">
                    <p class="small text-muted mt-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut consequatur cupiditate delectus ex iste laborum natus sed voluptatem. Dolores incidunt nulla voluptatum? Consequuntur cum deleniti doloremque enim mollitia odit, quis.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto at atque commodi consectetur dicta dolorem, ducimus eligendi esse et excepturi fugit iusto, laborum minus nemo pariatur quas rem rerum! Iure?</p>
                    <a href="#" class="btn btn-success">Support</a>
                </div>

                <div class="text-center mt-3">
                    Available Premium Votes (<i class="fa fa-star text-warning"></i>) = 0
                </div>

                <div class="header d-flex justify-content-between my-4 align-items-center">
                    <h2 class="h4">Amalia Sukhao's Profile</h2>
                    <div>
                        <a class="btn btn-outline-primary me-2" href="#">Polls Archive</a>
                    </div>
                </div>

                <div class="card card-body p-4 bg-light border-0 mb-4">
                    <h3 class="h5 mb-4 text-primary">Which of these songs do you prefer?</h3>
                    <div class="form-group mb-3">
                        <div class="d-flex justify-content-end">
                            <div class="form-check">
                                <input class="form-check-input mb-0" type="radio" name="role-1" id="role1-1" checked>
                                <label class="form-check-label mb-0 fw-normal" for="role1-1">Standard voting</label>
                            </div>
                            <div class="form-check ms-3">
                                <input class="form-check-input mb-0" type="radio" name="role-1" id="role2-1">
                                <label class="form-check-label mb-0 fw-normal" for="role2-1">Premium voting</label>
                            </div>
                        </div>
                    </div>
                    <ul class="answers list-group mb-3">
                        <li href="#" class="list-group-item mb-2 rounded text-center">Dusk Till Down - Sia</li>
                        <li href="#" class="list-group-item mb-2 rounded text-center">Dusk Till Down - Sia</li>
                        <li href="#" class="list-group-item mb-2 rounded text-center">Dusk Till Down - Sia</li>
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

                <div class="card card-body p-4 bg-light border-0 mb-4">
                    <h3 class="h5 mb-4 text-primary">Which of these songs do you prefer?</h3>
                    <div class="form-group mb-3">
                        <div class="d-flex justify-content-end">
                            <div class="form-check">
                                <input class="form-check-input mb-0" type="radio" name="role-2" id="role1-2">
                                <label class="form-check-label mb-0 fw-normal" for="role1-2">Standard voting</label>
                            </div>
                            <div class="form-check ms-3">
                                <input class="form-check-input mb-0" type="radio" name="role-2" id="role2-2" checked>
                                <label class="form-check-label mb-0 fw-normal" for="role2-2">Premium voting</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mb-3">
                        <div>
                            select <button class="btn btn-sm btn-primary">25%</button>
                            <button class="btn btn-sm btn-primary">50%</button>
                            <button class="btn btn-sm btn-primary">75%</button>
                            <button class="btn btn-sm btn-primary">100%</button> or use
                            <input type="text" class="form-control d-inline form-control-sm h-auto" style="width: 50px;">
                            <button type="button" data-bs-target="#vote-modal" data-bs-toggle="modal" class="btn btn-sm btn-primary"><i class="fa fa-check"></i></button>
                            <i class="fa fa-star text-warning"></i>
                        </div>
                    </div>
                    <ul class="answers list-group mb-3">
                        <li style="background: linear-gradient(to right, #2e86a6 51%, #ffffff 51%);" href="#" class="list-group-item mb-2 rounded">Dusk Till Down - Sia <span class="float-end">51%</span><button class="btn btn-light btn-sm ms-2"><i class="fa fa-message"></i></button></li>
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

            </div>
        </div>
    </div>
</section>
<footer class="bg-light p-4">
    <div class="text-center">&copy; Copyrights 2023, All Rights Reserved.</div>
</footer>


<div class="modal fade" id="vote-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-5 text-center">
                <form action="#">
                    <p>Proceed with using 75 <i class="fa fa-star text-warning"></i>?</p>
                    <div class="form-group mb-3">
                        <textarea name="comment" class="form-control" placeholder="Add a comment..." rows="5"></textarea>
                    </div>
                    <div>
                        <button class="btn btn-outline-primary px-4">Cancel</button>
                        <button class="btn btn-primary px-4 mx-2">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>