<template>
	<div class="row baking--schedule_holder scroll-custom">
		<div class="col-12 mb-3 px-0">
			<small class="">Baking Schedule</small>	
		</div>
		<div v-for="item in items" class="col-12 mb-3 px-0 baking--holder">
			<div class="w-100 inlineBlock-parent">
				<div class="w-20">
					<img class="img-contain mr-2" :src="item.selectedPastry.image_path" alt="">
				</div
				><div class="w-80">
					<small class="mb-2"><span> {{ item.selectedPastry.name }}</span></small>		
				</div>
			</div>
			
			<div class="w-100 inlineBlock-parent mb-1">
				<div class="w-20">
					
				</div
				><div class="w-80">
					<small class="text--small text-light-brown">{{ toDate(item.dateSelected) }} at {{ toTime(item.selectedTime, 'hh:mm A') }}</small>	
				</div>
			</div>
			<div class="w-100 inlineBlock-parent">
				<div class="w-20">
					
				</div
				><div class="w-80">
					<small class="font-weight-bold">{{ toMoney(item.totalPayment) }}</small>	
				</div>
			</div>	
		</div>

		<div class="divider w-100 mb-3"></div>

		<div class="w-100 inlineBlock-parent">
			<div class="w-50">
				<small>Total</small>
			</div
			><div class="w-50 text-right">
				<small class="font-weight-bold text-pink">{{ toMoney(grandTotal) }}</small>
			</div>
		</div>
	</div>
</template>

<script>
	import DateMixins from 'Mixins/date.js';
	import NumberMixins from 'Mixins/number.js';
	
	export default {

		data() {
			return {
				items: this.$parent.$parent.cart,	
			}
		},

		mixins: [ DateMixins, NumberMixins ],

		computed: {
			grandTotal() {
				var total = 0;
				_.each(this.items, (item) => {
					total += parseFloat(item.totalPayment);
				});

				return total;
			}
		}
	}
</script>