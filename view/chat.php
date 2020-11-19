<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"  >

    <script
            src="https://code.jquery.com/jquery-3.4.0.min.js"></script>


    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">


    <link rel="stylesheet" href="/static/css/style.css">

</head>
<body>






<section id="content">

    <div class="app container ">
        <div class="row">

            <div class="col-md-4 chats">

                <div class="col-md-12">


                    <div class="row pt-4" >

                        <div class="col-md-4 text-center align-self-center" style=" ">

                            <img src="/static/img/user.png" class="img-thumbnail rounded-circle" alt="">
                        </div>

                        <div class="col-md-8" style=" ">
                            <h6>{{ username }}</h6>

                            <p class="description green">online</p>


                        </div>
                    </div>

                </div>

                <div class="col-md-12 text-center search">

                    <input v-model = "search" @keyup = "searchd()" class="search-input" placeholder="Search peoples..." type="text">
                </div>

                <div class="col-md-12 inbox scrollbar " id="style-1">


                    <div v-if = "searchResults" v-for = "(result , i ) in searchResults" @click = "click(result)" class="row inbox-item pb-2" :class = "{'active': ( result.userid == selectedId)}" >

                        <div class="col-md-4 text-center my-auto ">

                            <img src="/static/img/user.png" class="img-thumbnail rounded-circle float-left img-fluid user-img" >
                        </div>
                        <div  class="col-md-6 align-self-center" >
                            <span class="bold">{{ result.username }}</span>
                            <p  class="description"> {{ '' }}</p>
                        </div>
                        <div style="display: none;" class="col-md-1 ms-count text-sm-center  align-self-center  ">1</div>
                        <div class="col-md-1 col-md-auto"></div>
                    </div>

                    <div v-if = "!searchResults" v-for = "(user , i ) in data" @click = "click(user)" class="row inbox-item pb-2" :class = "{'active': ( user.userid == selectedId)}" >

                        <div class="col-md-4 text-center my-auto ">

                            <img src="/static/img/user.png" class="img-thumbnail rounded-circle float-left img-fluid user-img" >
                        </div>
                        <div  class="col-md-6 align-self-center" >
                            <span class="bold">{{ user.username }}</span>
                            <p  class="description"> {{ user.latest }}</p>
                        </div>
                        <div style="display: none;" class="col-md-1 ms-count text-sm-center  align-self-center  ">1</div>
                        <div class="col-md-1 col-md-auto"></div>
                    </div>

                </div>
            </div>


            <div v-if = "username" class="col-md-8 chat-inbox" >


                <div class="row text-center chat-head">

                    <div class="col-md-4 my-auto">
                        <img style="height: 70px" src="static/img/user.png" class=" img-thumbnail rounded-circle img-fluid user-img  ">
                    </div>
                    <div class="col-md-8 pt-2">
						<span class="text-center float-left" >
						<h5>{{ username }}</h5>
                        <p :class ="{'red' : !online , 'green' : online }" > {{ online ? 'online' : 'offline' }} </p>
						</span>
                    </div>
                </div>

                <div id="style-1"   class="col-md-12 text-center chat-body pt-1  scrollbar">


                    <div class="pt-3" v-for = "msg in messages">
                        <div v-if = "msg.from === myid" class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 msg-outgoing">
                            {{ msg.text }}
                            </div>
                        </div>

                        <div  v-else class="row">
                            <div class="col-md-6 msg-incoming">
                                {{ msg.text }}
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>

                </div>
                <div   class="col-md-12 text-center  chat-foot">
                    <div class="row">
                        <div class="col-md-10 pt-3">
                            <input
                                    type="text"
                                    class="msg-input"
                                    v-on:keyup.enter = "send()"
                                    ref="send"
                                    v-model  ="text"
                            >
                        </div>
                        <div class="col-md-2 pt-3 ">
                            <div class="send-btn">
                                <svg  @click = "send()" aria-hidden="true" focusable="false" data-prefix="far" data-icon="paper-plane" class="svg-inline--fa fa-paper-plane fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M440 6.5L24 246.4c-34.4 19.9-31.1 70.8 5.7 85.9L144 379.6V464c0 46.4 59.2 65.5 86.6 28.6l43.8-59.1 111.9 46.2c5.9 2.4 12.1 3.6 18.3 3.6 8.2 0 16.3-2.1 23.6-6.2 12.8-7.2 21.6-20 23.9-34.5l59.4-387.2c6.1-40.1-36.9-68.8-71.5-48.9zM192 464v-64.6l36.6 15.1L192 464zm212.6-28.7l-153.8-63.5L391 169.5c10.7-15.5-9.5-33.5-23.7-21.2L155.8 332.6 48 288 464 48l-59.4 387.3z"></path></svg>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div v-else style="font-weight: bold; font-size: 40px" class="col-md-8 text-center pt-5"> Sol tərəfdən danışmaq istədiyiniz adamı seçin</div>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="/static/js/app.js" >  </script>
</body>
</html>