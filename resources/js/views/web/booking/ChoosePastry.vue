<template>
	<div class="frm-cntnr mt-5">
		<div class="w-100">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-8">
					<p class="frm-title text-secondary">ALL PRODUCTS</p>
				</div>
				<div class="col-md-6 col-sm-6 text-right col-4">
					<span class="inlineBlock-parent baking--sched"><p class="font-weight-bold mb-0 mr-2 desktop-show">Baking Schedule</p> <img data-toggle="modal" data-target="#bakingModal" class="choose-icon img-contain" src="../../../../../public/images/assets/calendar.png" alt="">

					<div class="baking--notif">
						<div class="vertical-parent">
							<div class="vertical-align">
								<small class="font-weight-bold text-white">1</small>
							</div>
						</div>
					</div>

					</span>
				</div>
			</div>

			<div class="row product--sort">
				<div class="col-md-1 col-sm-1 col-3">
					<small class="mb-0 text-muted">Sort by:</small>
				</div>
				<div class="col-2 desktop-show">
					<select-fields
					:items="categories"
					item-value="id"
					item-text="category"
					placeholder="Category">
					</select-fields>
				</div>
				<div class="col-2 desktop-show">
					<select-fields
					:items="difficulties"
					item-value="id"
					item-text="difficulty"
					placeholder="Difficulty">
					</select-fields>
				</div>
				<div class="col-2 desktop-show">
					<select-fields
					:items="durations"
					item-value="id"
					item-text="duration"
					placeholder="Duration">
					</select-fields>
				</div>
				<div class="col-md-5 col-sm-5 col-9">
					<search-field 
					placeholder="Search"></search-field>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div v-for="product in products" class="col-sm-6 col-md-4 col-6 mb-5 product-card__holder">
						<product-card
						:items="products"
						></product-card>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import Selector from '../../../components/inputs/Select.vue';
import  SearchField from '../../../components/inputs/SearchField.vue';
import ProductCard from './ProductCard.vue';
	
	export default {
		components: {
			'select-fields' : Selector,
			'search-field' : SearchField,
			'product-card' : ProductCard,
		},

		data: function () {
			return {
				categories: [{id: '1', category: 'Category 1'}, {id: '2', category: 'Category 2'}],
				difficulties: [{id: '1', difficulty: 'Hard'}, {id: '2', difficulty: 'Normal'}, {id: '3', difficulty: 'Easy'}],
				durations: [{id: '1', duration: '1 Hour'}, {id: '2', duration: '2 Hours'}, {id: '3', duration: '3 Hours'}],
				products: [],
				products: 1,
			}
		}
	}
</script>