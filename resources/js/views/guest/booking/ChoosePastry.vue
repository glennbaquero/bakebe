	<template>
	<div class="frm-cntnr mt-5">
		<div class="w-100">
			<div class="row mb-2">
				<div class="col-md-6 col-sm-8 col-8 align-self-center">
					<p class="frm-title text-secondary mb-0">ALL PRODUCTS</p>
				</div>
				<div class="col-md-6 col-sm-4 col-4 text-right align-self-center">
					<span class="inlineBlock-parent baking--sched" @click="showCartItems()"><p class="font-weight-bold mb-0 mr-2 desktop-inline-show">Baking Schedule</p> <img class="choose-icon img-contain" src="/images/assets/calendar.png" alt="">

					<div class="baking--notif">
						<div class="vertical-parent">
							<div class="vertical-align">
								<small class="font-weight-bold text-white">{{ item_count }}</small>
							</div>
						</div>
					</div>

					</span>
				</div>
			</div>

			<div class="row product--sort">
				<div class="col-md-1 col-sm-1 col-3 pl-2 pr-0 align-self-center">
					<small class="mb-0 text-muted">Sort by:</small>
				</div>
				<div class="col-2 desktop-show align-self-center">
					<select-fields
	                @change="filter($event, 'category_id')"
					:items="categories"
					item-value="id"
					item-text="name"
					placeholder="Category">
					</select-fields>
				</div>
				<div class="col-2 desktop-show align-self-center">
					<select-fields
	                @change="filter($event, 'difficulty')"
					:items="difficulties"
					item-value="id"
					item-text="name"
					placeholder="Difficulty">
					</select-fields>
				</div>
				<div class="col-2 desktop-show align-self-center">
					<select-fields
	                @change="filter($event, 'duration')"
					:items="durations"
					item-value="id"
					item-text="name"
					placeholder="Duration">
					</select-fields>
				</div>
				<div class="col-md-5 col-sm-5 col-9 align-self-center">
					<div class="w-90 ml-auto mr-0">
						<search-field 
					placeholder="Search" @search="filter($event, 'search')"></search-field>
					</div>
				</div>
			</div>

		
			<div class="w-100 mt-3">
				<data-table
				ref="data-table"
				class="row mx-0"
				:headers="headers"
				:filters="filters"
				:fetch-url="fetchUrl"
				:no-action="true"
				:disabled="disabled"
				:is-table="false"
				order-by="created_at"
				@load="load"
				>
					<template v-slot:body="{ items }">
						<div v-for="item in items" class="col-6 col-sm-6 col-md-4 mb-5 product--card_holder">
							<product-card
							:item="item"
							@selected="selectedItem(...arguments)"
							></product-card>
						</div>
					</template>
				</data-table>
			</div>
			
		</div>
		<booking-modal v-if="showBookingModal"
			:selected-pastry="selectedPastry" 
			:block-dates-intervals="blockDatesIntervals" 
			:timeslot-url="timeslotUrl" 
			:fullybooked-url="fullybookedUrl" 
			:create-item-url="createItemUrl"
			:payloads="payloads"
		></booking-modal>
		<edit-booking-modal 
			:block-dates-intervals="blockDatesIntervals" 
			:timeslot-url="timeslotUrl" 
			:fullybooked-url="fullybookedUrl" 
			:payloads="payloads"
		></edit-booking-modal>
		<loading 
			:active.sync="isLoading" 
	        :is-full-page="true"
	        color="#e8627c"
		></loading>
	</div>
</template>
<script>
import ListMixin from 'Mixins/list.js';

import Selector from 'Components/inputs/Select.vue';
import SearchField from 'Components/inputs/SearchField.vue';
import ProductCard from './ProductCard.vue';
import BookingModal from '../modals/BookingModal.vue'
import EditBookingModal from '../modals/EditBookingModal.vue'
import { EventBus } from 'Root/EventBus.js';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
	
	export default {
		props: {
			fetchUrl: String,
			createItemUrl: String,
			timeslotUrl: String,
			fullybookedUrl: String,
			blockDatesIntervals: Array,
			payloads: Object
		},

	    mixins: [ ListMixin ],

		components: {
			'select-fields' : Selector,
			'search-field' : SearchField,
			'product-card' : ProductCard,
			'booking-modal' : BookingModal,
			'edit-booking-modal' : EditBookingModal,
			Loading
		},

		data() {
			return {
				categories: [ 
					{
						name: 'All',
						id: 0 
					} 
				],
				difficulties: [
					{
						name: 'All',
						id: 0 
					} 
				],
				durations: [
					{
						name: 'All',
						id: 0 
					} 
				],
				selectedPastry: {},
				showBookingModal: false,
				isLoading: false
			}
		},

		computed: {
			item_count() {
				return this.$parent.cart.length;
			},

			isBirthdayPromo() {
				var promoSelected = this.payloads.selectedPromo;
			},
		},

		mounted() {
			var computedcart = this.$parent.computedCart

			setTimeout(() => {
				this.init();
			}, 200)
			setTimeout(() => {
				if(this.payloads.promoSelected.promo_category_id === 3) {
					$('.birthday--modal').modal('toggle');
				}
			}, 200)

		},

		methods: {
			init() {
				this.getFilters();
				EventBus.$emit('show--cart');
			},

			getFilters() {
				this.isLoading = true;
				var type = 'express';

				if(this.payloads.selectedType.id === 1) {
					type = 'regular';
				}

				this.$refs['data-table'].filters['type'] = type;

				this.$refs['data-table'].fetch();

				axios.post(this.fetchUrl, { per_page: 9999999, type: type }) 
					.then(response => {
						var items = response.data.items;

						_.each(items, (item) => {
							var difficulty = {
								id: item.difficulty,
								name: item.difficulty,
							}

							var category = {
								id: item.category_id,
								name: item.category,
							}
							var duration = {
								id: item.duration,
								name: item.duration_label,
							}
							this.difficulties.push(difficulty);
							this.categories.push(category);
							this.durations.push(duration);
							this.durations.sort((a, b) => parseFloat(b.id) - parseFloat(a.id))
							this.difficulties.sort((a, b) => parseFloat(a.id) - parseFloat(b.id))
						})
						this.isLoading = false;
					})
			},

			selectedItem(item) {
				this.selectedPastry = item;
				this.showBookingModal = true;

				setTimeout(() => {
					$('.booking--modal').modal('toggle');
				}, 200)
			},

			showCartItems() {
				EventBus.$emit('show--cart');
				 $('.baking--modal').modal('toggle');
			}
		}
	}
</script>