Vue.component('dialog-container', require('../../components/dialogs/DialogContainer.vue').default);

Vue.component('article-list', require('./articles/ArticleList.vue').default);
Vue.component('selected-article', require('./articles/SelectedArticle.vue').default);
Vue.component('booking-view', require('./booking/BookingView.vue').default);
// Vue.component('login-view', require('./pages/Login.vue').default);
Vue.component('signup-view', require('./pages/Signup.vue').default);
Vue.component('forgot-password', require('./pages/ForgotPassword.vue').default);
Vue.component('home-view', require('./pages/Home.vue').default);
Vue.component('dashboard-view', require('./dashboard/DashboardView.vue').default);
Vue.component('store-locator', require('./pages/StoreLocator.vue').default);

Vue.component('birthday-modal', require('./modals/BirthdayModal.vue').default);
Vue.component('birthappointment-modal', require('./modals/BirthdayAppointmentModal.vue').default);

Vue.component('TextField', require('Components/inputs/TextField.vue').default);
Vue.component('PasswordField', require('Components/inputs/Password.vue').default);

