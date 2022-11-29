<template>

    <div class="card ">
        <div class="card-header mb-2">
            Sales Chart 
        </div>

        <date-range
        @change="filter($event)"
        ></date-range>

        <div class="col-sm-12">
            <selector class="ml-2 mr-2"
            :items="filterBranch"
            item-value="id"
            item-text="name"
            @change="filter($event, 'branch_ids')"
            placeholder="Filter by Branch"
            multiple
            ></selector>
        </div>
        
        <!-- <div class="card-body " style="height: 350px;"> -->
            <chartist v-if="data.chartData.series[0].length >= 1"
                type="Line"
                style="height: auto"
                class="ct-chart ct-golden-section container-fluid"
                :data="data.chartData"
                :options="data.chartOptions"
            ></chartist> 
        <!-- </div> -->

    </div>
        

</template>


<script type="text/javascript">
Vue.use(require('vue-chartist'),{
      messageNoData: "You have not enough data"
});
import Chartist from 'chartist';
import * as ChartistTooltips from 'chartist-plugin-tooltips';
import ctPointLabels from 'chartist-plugin-pointlabels';
import DateRange from '../../../components/datepickers/DateRange.vue';
import Selector from '../../../components/inputs/Select.vue';

export default {
    props: {

        fetchUrl:String,
        filterBranch: {},

    },

    mounted () {
        this.fetch();
         
    },

    methods: {
        fetch() {
            axios.post(this.fetchUrl, this.params).then(response => {
                console.log(response.data);
                
                this.data.chartData.labels = response.data.labels;
                this.data.chartData.series =  response.data.series;

             });
        },

        filter(event, element = null) {
            if(element){
                this.params[element] = event;
            }else {
                for (var key in event) {
                    this.params[key] = event[key];
                }
            }

            this.fetch();

        },
    },

    data() {
            return {
                params: {},
                data: 
                {

                    chartData:
                    { 

                        labels: [],
                        series:[],

                    },  

                    chartOptions: 
                    {
                        showArea: true,
                        fullWidth: true,
                        ShowLabel: true,
                        lineSmooth: false,

                        axisX: { offset: 75 },

                        plugins: [
                            ctPointLabels({
                              textAnchor: 'middle',
                              labelInterpolationFnc: (value) => { if (typeof value === "undefined") return "0"; else return value; } 
                            })
                          ]

                    },

                }
            }

        },

    components: {
        'date-range': DateRange,
        'selector': Selector,
    },

}
</script>
