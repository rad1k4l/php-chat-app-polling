window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
};
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';



// this.$refs.send.focus();
let inbox = new Vue({
    el:".chat-inbox",
    data: {
        username: false,
        messages : false,
        userid : false,
        text : '',
        online : false,
        myid : false
    },
    methods : {
        send : async function(){

            if (this.text === false || this.text.length === 0) return false;

            axios .post('/api/send' ,  this.query({to : this.userid , text : this.text}));
            this.text = "";
            chats.searchResults = false;
            chats.search = '';
            await this.update();
            chats.scroll(9999999999999999999);
            return true;

        },
        set : function(user){
            this.userid = user.userid;
            this.username = user.username;
            this.online = user.online;
        },
        query: function (queries){
            let params = new URLSearchParams();
            for(let key in queries){
                let value = queries[key];
                params.append(key , value);
            }
            return    params.toString();
        },
        update : async function(){

            if (this.userid === false) return false;

            let response = await axios .post('/api/inbox' ,  this.query({to : this.userid})  );

            if(response.data.status === "ok" || response.data.status === undefined) {
                this.messages = response.data;
            }else{
                this.username = 'error';
            }
            return true;
        },
    }
});


let chats = new Vue({
  el : ".chats",
  data: {
      selectedId: false,
      data: false,
      search : '',
      user: false,
      username: '',
      searchResults : false
  },
  methods : {

     searchd : async  function(){

         if(this.search.length === 0) return this.searchResults = false;

         let response = await axios
             .get('/api/search' , { params: { query : this.search }});
         if(response.data.status === "ok" || response.data.status === undefined) {
            this.searchResults = response.data;
         }else{
           // error
         }
     },

    setUser : async function(){
        let response = await axios
            .get('/api/getuser' );
        if(response.data.status === "ok" || response.data.status === undefined) {
            this.username = response.data.name;
            this.user = response.data.id;
            inbox.myid = this.user;
        }else{
            this.username = 'error';
        }

    },
    update : async function (){
        if(this.search.length !== 0 && this.user === false){
            return false;
        }
      let that = this;

      let response = await axios
          .get('/api/chats' , { params: {userid : this.user }});
      this.data = response.data;

      for (a = 0 ; a < this.data.length ; a++ ){
          if(this.data[a].id === inbox.userid){
              inbox.online = this.data[a].online;
          }
      }
      return true;
    },
    click : async function (user) {
          this.selectedId = user.userid;
          await  inbox.set(user);
              try {
                 await inbox.$refs.send.focus();
              }catch (e) { }
              
        this.scroll(99999);
    },
      scroll : function (px = 500) {
          $('.chat-body').scrollTop(px);
      }
  }
});
// while (!chats.user)

    chats.setUser();
window.setInterval(function () {
    chats.update();
},1000);


window.setInterval(function () {
    inbox.update();
},1000);




















Math.easeOutQuad = function (t, b, c, d) { t /= d; return -c * t*(t-2) + b; };

(function() { // do not mess global space
var
  interval, // scroll is being eased
  mult = 0, // how fast do we scroll
  dir = 0, // 1 = scroll down, -1 = scroll up
  steps = 1, // how many steps in animation
  length = 1; // how long to animate
function MouseWheelHandler(e) {
  // console.log("wheel");
  e.preventDefault(); // prevent default browser scroll
  clearInterval(interval); // cancel previous animation
  ++mult; // we are going to scroll faster
  var delta = -Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail))); // cross-browser
  if(dir!=delta) { // scroll direction changed
    mult = 1; // start slowly
    dir = delta;
  }
  // in this cycle, we determine which element to scroll
  for(var tgt=e.target; tgt!=document.documentElement; tgt=tgt.parentNode) {
    var oldScroll = tgt.scrollTop;
    tgt.scrollTop+= delta*100;
    if(oldScroll!=tgt.scrollTop) break;
    // else the element can't be scrolled, try its parent in next iteration
  }
  var start = tgt.scrollTop;
  var end = start + length*mult*delta; // where to end the scroll
  var change = end - start; // base change in one step
  var step = 0; // current step
  interval = setInterval(function() {
    var pos = Math.easeOutQuad(step++,start,change,steps); // calculate next step
    tgt.scrollTop = pos; // scroll the target to next step
    if(step>=steps) { // scroll finished without speed up - stop animation
      mult = 0; // next scroll will start slowly
      clearInterval(interval);
    }
  },10);

  // return false;
}

// nonstandard: Chrome, IE, Opera, Safari
window.addEventListener("mousewheel", MouseWheelHandler, { passive: false }); 
// nonstandard: Firefox
window.addEventListener("DOMMouseScroll", MouseWheelHandler, { passive: false });
})();