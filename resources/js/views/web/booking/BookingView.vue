<template>
	<div class="frm-cntnr booking--holder">
		<step-progress></step-progress>
		<div class="w-90 mx-auto pb-5">	
			<div class="w-100 booking-holder__inner inlineBlock-parent">
				<div class="w-60 align-t">
					<location></location>	
					<booking-type></booking-type>
					<choose-pastry></choose-pastry>
					<payment-option></payment-option>
				</div
				><div class="w-40 align-t">
					<booking-information></booking-information>	
				</div>
			</div>
			<div class="w-100">
				<checkout-summary></checkout-summary>	
			</div>
			<div class="w-100">
				<appointment-modal></appointment-modal>
				<baking-modal></baking-modal>
				<voucher-modal></voucher-modal>
				<login-modal></login-modal>
				<terms-modal></terms-modal>
				<success-modal></success-modal>
			</div>
		</div>
	</div>
</template>
<script>
import StepProgress from './StepProgress.vue';
import Location from './Location.vue';
import BookingType from './BookingType.vue';
import ChoosePastry from './ChoosePastry.vue';
import PaymentOption from './PaymentOption.vue';
import CheckoutSummary from './CheckoutSummary.vue';
import BookingInformation from './BookingInformation.vue';
import AppointmentModal from '../modals/AppointmentModal.vue';
import BakingScheduleModal from '../modals/BakingScheduleModal.vue';
import VoucherModal from '../modals/VoucherModal.vue';
import LoginModal from '../modals/LoginModal.vue';
import TermsModal from '../modals/TermsModal.vue';
import SuccessModal from '../modals/SuccessModal.vue';

export default {
	components: {
		'step-progress' : StepProgress,
		'location' : Location,
		'booking-type' : BookingType,
		'choose-pastry' : ChoosePastry,
		'payment-option' : PaymentOption,
		'checkout-summary' : CheckoutSummary,
		'booking-information' : BookingInformation,
		'appointment-modal' : AppointmentModal,
		'baking-modal' : BakingScheduleModal,
		'voucher-modal' : VoucherModal,
		'login-modal' : LoginModal,
		'terms-modal' : TermsModal,
		'success-modal' : SuccessModal,
	}, 
}
</script>