export default {
	methods: {
		toDate(value, format = 'MMMM DD, YYYY') {
			let result = '';

			if (moment(new Date(value)).isValid()) {
				result = moment(new Date(value)).format(format);
			}

			return result;
		},

		toTime(value, format = 'HH:mm') {
			let result = '';
			
			if (moment(new Date(value)).isValid()) {
				result = moment(new Date(value)).format(format);
			} else {
				result = moment(value, format).format(format)
			}

			return result;
		},

		fromNow(value) {
			let result = '';
			
			if (moment(new Date(value)).isValid()) {
				result = moment(new Date(value)).fromNow();
			}

			return result;
		},

		moment() {
			return {
				getPastYear(years = 1) {
					return moment(new Date).subtract(years, 'years').format('YYYY-MM-DD');
				},
			};
		},
	},
}