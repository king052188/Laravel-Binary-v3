
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

var counter = 0;

const app = new Vue({
    el: '#app',
    created() {
      Echo.channel('channelAlertUsers')
        .listen('eventTrigger', (e) => {

          if(e.type == "notifyUsers") {
            var html = "<div class='alert alert-danger' role='alert' style='text-align: center; margin-bottom: 0;'>";
            html += e.description;
            html += "</div>";
            $("#notifyUsers").empty().prepend(html).fadeOut(5000);
          }
          else {
            if(counter > 10) {
             $("#tbl_usersTransactions > tbody tr:eq(10)").fadeOut('slow');
            }
            var html = "<tr>"
            html += "<td>"+ counter +"</td>";
            html += "<td>"+ e.account +"</td>";
            html += "<td>"+ e.description +"</td>";
            html += "<td>"+ e.timestamp +"</td>";
            html += "</tr>";
            $('#tbl_usersTransactions > tbody').prepend(html);
            counter++;
          }
        });
    }
});
