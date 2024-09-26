/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});



//OPPORTUNITY DASHBOARD
//DASHBOARD OPPORTUNITIES
window.addStageList =  function(stage_id, stage_list_route, opportunities_stage_html, opportunities_html_wrapper, search_input, userDashboard){
    //Enviamos una solicitud con el ruc de la empresa
    $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: stage_list_route,
        tryCount : 0,
        retryLimit : 3,
        dataType : "json",
        data:{
            stage_id: stage_id,
            search_input: search_input,
            user_dashboard: userDashboard,
        },
        success: function (data) {
            //console.log("-----------------STAGE "+stage_id+"----------------");
            //console.log(data);
            $(data).each(function (index,value) {
                //console.log("--------STAGE OPP "+stage_id+"--------");
                //CLONE THE TEMPLATE
                let cloned_template = $("#opportunity-template .opportunity-wrapp").clone();
                //FILL TEMPLATE WITH DATA
                cloned_template.attr("data-id",value.id);
                cloned_template.attr("data-order",value.order);
                cloned_template.attr("data-price",value.service_price);
                cloned_template.attr("data-probability",value.probability);
                cloned_template.find(".opportunity-single-title").html(value.name);
                cloned_template.find(".opportunity-single-company").html(value.company.company_name);
                cloned_template.find(".opportunity-single-price").html(value.service_price);
                //HREF TO VIEW OPPORTUNITY
                let view_opportunity_route = cloned_template.find(".view-opportunity").attr("data-href");
                view_opportunity_route = view_opportunity_route.replace('replace', value.id);
                cloned_template.find(".view-opportunity").attr("href", view_opportunity_route);
                //ADD ELEMENT TO STAGE LIST
                $("."+opportunities_html_wrapper+"-"+stage_id).append(cloned_template);
                //ADD SORTABLE FUNCTIONALITY TO ELEMENT
                makeSortable(opportunities_stage_html, opportunities_html_wrapper, stage_id);
                //console.log(value);
            });
            //console.log("-----------------STAGE "+stage_id+"----------------");
        },error:function(data){
            console.log("-----------------ERROR----------------");
            this.tryCount++;
            console.log("Try: "+this.tryCount+" out of "+this.retryLimit+".");
            if (this.tryCount <= this.retryLimit) {
                //try again
                $.ajax(this);
                return;
            }
            console.log(data);
            console.log("-----------------ERROR----------------");
        }
    });
};


window.makeSortable = function(opportunities_stage_html,opportunities_html_wrapper, stage_id) {

    $( "."+opportunities_stage_html ).each(function( index ) {
        $(this).find("."+opportunities_html_wrapper).sortable({
            connectWith: $('.'+opportunities_html_wrapper),
            delay: 150,
            stop: function( event, ui ) {
                //make updated opportunity consistent
                //RETRIEVE THE ITEM MOVED
                let item_moved = ui.item;
                //update values on db
                updateOpportunity(item_moved);
                //update values locally
                updateValuesLocally();

            }
        });

    });

};
window.updateOpportunity = function(item_moved) {
    //GET INFORMATION OF OPPORTUNITY
    let opportunity = item_moved.attr("data-id");
    let order = item_moved.index()+1;
    console.log("new order: "+order);
    //RETRIEVE THE STAGE FROM PARENT
    let opportunity_stage_item = item_moved.closest(".opportunities-stage-wrapp");
    //RETRIEVE THE STAGE
    let stage = opportunity_stage_item.attr("data-id");
    console.log("Opportunity: "+opportunity);
    console.log("Order: "+ order);
    console.log("Moved to stage: "+stage);

    //Enviamos una solicitud con el ruc de la empresa
    $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: opportunity_update_route,
        tryCount : 0,
        retryLimit : 3,
        dataType : "json",
        data:{
            stage: stage,
            opportunity: opportunity,
            order: order,
        },
        success: function (data) {
            if (data == "200") {
                //try again
                console.log("Se actualizó la oportunidad con éxito.");
                return;
            }else{
                alert("Ocurrió un error, por favor cargue la página e intente de nuevo la operación.")
            }
            console.log(data);
        },error:function(data){
            console.log("-----------------ERROR----------------");
            this.tryCount++;
            console.log("Try: "+this.tryCount+" out of "+this.retryLimit+".");
            if (this.tryCount <= this.retryLimit) {
                //try again
                $.ajax(this);
                return;
            }else{
                alert("Ocurrió un error, por favor cargue la página e intente de nuevo la operación.")
            }
            console.log(data);
            console.log("-----------------ERROR----------------");
        }
    });


}
window.updateValuesLocally = function() {

    $( ".opportunities-stage-wrapp" ).each(function( index ) {
        let opportunities_child = $(this).find(".opportunity-wrapp");
        let opportunities_count = opportunities_child.length;
        let stage_id = $(this).attr("data-id");

        $(this).find(".opportunities-stage-count").html(opportunities_count);
        //opportunity-stage-total-amount
        let total_amount = 0;
        $(opportunities_child).each(function( index ) {
            let opportunity_price = parseFloat($(this).attr("data-price"));
            total_amount+=opportunity_price;
            //console.log( "Opportunity price: "+opportunity_price);
        });
        $(this).find(".opportunity-stage-total-amount-"+stage_id).html(total_amount);
        //console.log( "Opportunities on stage "+stage_id+": "+opportunities_count);
        //console.log( "Price on stage "+stage_id+": "+total_amount);
    });

}


window.addTotalPrice = function(stage_id, stage_price_route, opportunities_price_html_wrapper, search_input, userDashboard){
    //Enviamos una solicitud con el ruc de la empresa
    $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: stage_price_route,
        tryCount : 0,
        retryLimit : 3,
        dataType : "json",
        data:{
            stage_id: stage_id,
            search_input: search_input,
            user_dashboard: userDashboard,
        },
        success: function (data) {
            //console.log("-----------------STAGE "+stage_id+"----------------");
            //console.log(data);
            $("."+opportunities_price_html_wrapper+"-"+stage_id).html(data);
            //console.log("-----------------STAGE "+stage_id+"----------------");

        },error:function(data){
            console.log("-----------------ERROR----------------");
            this.tryCount++;
            console.log("Try: "+this.tryCount+" out of "+this.retryLimit+".");
            if (this.tryCount <= this.retryLimit) {
                //try again
                $.ajax(this);
                return;
            }
            console.log(data);
            console.log("-----------------ERROR----------------");
        }
    });
}



window.search = function(element, e) {
    console.log("evento: "+e.type);

    let model_html_wrapper = element.closest(".list-model-wrapp").attr("id");
    let search_input = element.closest(".list-model-wrapp").find(".search_input").val();
    let url = element.closest(".list-model-wrapp").find(".search_input").attr('data-href');

    $("#"+model_html_wrapper).append('Cargando los datos...');
    var url_without_parameters = url.split('?')[0];
    var page = getURLParameter(url, 'page');

    console.log("Model html wrapper: "+model_html_wrapper);
    console.log("url: "+url);
    console.log("search input: "+search_input);
    console.log("url without parameters: "+url_without_parameters);
    console.log("Page: "+page);

    addStageList(page, url_without_parameters, model_html_wrapper, search_input);
}


//DASHBOARD OPPORTUNITIES
window.addCompanyContacts =  function(company, company_contacts_route){
    //Enviamos una solicitud con el ruc de la empresa
    $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: company_contacts_route,
        tryCount : 0,
        retryLimit : 3,
        dataType : "json",
        data:{
            company: company,
        },
        success: function (data) {
            console.log(data);
            $('#company_contact_id').html("");
            $(data).each(function (index,value) {
                $('#company_contact_id').append($('<option>', {
                    value: value.id,
                    text : value.name+" "+value.last_name
                }));
            });

        },error:function(data){
            console.log("-----------------ERROR----------------");
            this.tryCount++;
            console.log("Try: "+this.tryCount+" out of "+this.retryLimit+".");
            if (this.tryCount <= this.retryLimit) {
                //try again
                $.ajax(this);
                return;
            }
            console.log(data);
            console.log("-----------------ERROR----------------");
        }
    });
};
//OPPORTUNITY DASHBOARD

//REPORTS



window.getAndDrawUsersOpportunities =  function(timePeriod, users_opportunities_sum_route, canvas_id, type){
    //Enviamos una solicitud con el ruc de la empresa
    $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: users_opportunities_sum_route,
        tryCount : 0,
        retryLimit : 3,
        dataType : "json",
        data:{
            timePeriod: timePeriod,
        },
        success: function (data) {
            console.log("-----------------users Opportunities Sum----------------");
            console.log(data);
            //UPDATE VALUE GLOBALLY
            window.chartUserOpportunities = drawVerticalBar(data, canvas_id, chartUserOpportunities);
        },error:function(data){
            console.log("-----------------ERROR----------------");
            this.tryCount++;
            console.log("Try: "+this.tryCount+" out of "+this.retryLimit+".");
            console.log(data);
            if (this.tryCount <= this.retryLimit) {
                //try again
                $.ajax(this);
                return;
            }
            console.log(data);
            console.log("-----------------ERROR----------------");
        }
    });
};

window.drawChart =  function(data, canvas_id, chart, title, chart_type){
    let data_length = data.length;

    let randomColors = randomColorGraph(data_length);

    let labels_arr = [];
    let data_arr = [];
    $(data).each(function (index,value) {
        let name = value.name;
        let sum = value.sum;
        labels_arr.push(name);
        data_arr.push(sum);
    });

    //DIBUJAMOS LA DATA
    var ctx = $('#'+canvas_id);
    chart = new Chart(ctx, {
        type: chart_type,
        data: {
            labels: labels_arr,
            datasets: [{
                label: title,
                data: data_arr,
                backgroundColor: randomColors.graphColors,
                hoverBackgroundColor: randomColors.hoverColor,
                borderColor: randomColors.graphOutlines,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            annotation: {
                annotations: [{
                    type: 'line',
                    mode: 'horizontal',
                    scaleID: 'y-axis-0',
                    value: 0.5,
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 4,
                    label: {
                        enabled: false,
                        content: 'Test label'
                    }
                }]
            }
        }
    });

};

window.drawBoxChartNew =  function(data, canvas_id){

    //DIBUJAMOS LA DATA
    var ctx = $('#'+canvas_id);
    chart = new Chart(ctx, {
        type: 'boxplot',
        data: {
            labels: [],
        },
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: false,
                text: 'Chart.js Box Plot Chart',
            },
            scales: {
                xAxes: [],
            },
        },
    });

    return chart;


};

window.drawChartNew =  function(data, canvas_id, title, chart_type){
    let data_length = data.length;

    let randomColors = randomColorGraph(data_length);

    let labels_arr = [];
    let data_arr = [];
    $(data).each(function (index,value) {
        let name = value.name;
        let sum = value.sum;
        labels_arr.push(name);
        data_arr.push(sum);
    });

    //DIBUJAMOS LA DATA
    var ctx = $('#'+canvas_id);
    chart = new Chart(ctx, {
        type: chart_type,
        data: {

        },
        options: {
            legendCallback: function (chart) {
                // Return the HTML string here.
                console.log($chartUserWon.data.datasets);
                legendLabelsArr = new Array();
                var text = [];
                text.push('<ul class="' + $chartUserWon.id + '-legend">');
                for (var i = 0; i < $chartUserWon.data.datasets.length; i++) {
                    let labelTxt = $chartUserWon.data.datasets[i].label;
                    var found = jQuery.inArray(labelTxt, legendLabelsArr);
                    if (found < 0) {
                        legendLabelsArr.push(labelTxt);
                        text.push('<li><span id="legend-' + i + '-item" style="background-color:' + $chartUserWon.data.datasets[i].backgroundColor + '"   onclick="updateDataset(event, ' + '\'' + i + '\'' + ')">');

                        text.push('</span></li>');
                        if ($chartUserWon.data.datasets[i]) {
                            text.push(labelTxt);
                        }
                    }
                }
                text.push('</ul>');
                return text.join("");
            },
            "animation": {
                "duration": 0.1,
                "onComplete": function(chart) {
                    var chartInstance = this.chart,
                        ctx = chartInstance.ctx;

                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function(dataset, i) {
                        if($chartUserWon.data.datasets[i].type == 'bar'){
                            console.log($chartUserWon.data.datasets[i]);
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                let pointStyle = pointStyleBasin.indexOf($chartUserWon.data.datasets[i].pointStyle);
                                let samplingPointID = pointStyleBasin.indexOf($chartUserWon.data.datasets[i].pointStyle);
                                let samplingPointName = samplingPoints.filter(obj => {
                                    return obj.id === samplingPointID
                                })[0].name;
                                var data = samplingPointName;

                                console.log("MMMMMMMMMMMMMMMMMMMMMMMMMM");
                                console.log($chartUserWon.data.datasets[i].label);
                                console.log(ctx.canvas.height);
                                console.log(bar._model.y);
                                console.log(ctx.canvas.height - bar._model.y);
                                ctx.save();
                                ctx.translate(bar._model.x, bar._model.y);
                                ctx.rotate(-Math.PI/2);
                                let offsetY = 35;
                                if(bar._model.y < 60){
                                    offsetY = -38;
                                }
                                ctx.fillText(data, offsetY, 7);
                                ctx.restore();
                            });
                        }
                    });

                }
            },
            bezierCurve: false,
            scales: {
                yAxes: [
                ],
                xAxes: [{
                    offset: offset,
                    //barThickness: 'auto',  // number (pixels) or 'flex'
                    //maxBarThickness: 'auto', // number (pixels)
                    barPercentage: 0.8,
                    type: "time",
                    time: {
                        unit: 'day',
                        unitStepSize: 1,
                        parser: 'MM/DD/YYYY HH:mm',
                        tooltipFormat: 'll HH:mm',
                        displayFormats: {
                            'day': 'DD/MM/Y'
                        }
                    },
                    ticks: {
                        source: 'data',
                    },
                    // quitar esto para q los puntos se espacien de acuerdo al tiempo pasado
                    distribution: 'series',
                    bounds: 'ticks',
                    scaleLabel: {
                        display: true,
                        labelString: 'Periodo',
                        fontSize: 17
                    },

                }],
            },
            annotation: {
                annotations: [{

                }]
            },
            regressions: {
                type: 'linear',
                line: { color: 'blue', width: 3 },
            },
            legend: {
                display:false,
                labels: {
                    fontSize: 14,
                    /*
                                        filter: function (legendItem, chartData, legends) {
                                            let labelTxt = chartData.datasets[legendItem.datasetIndex].label;
                                            console.log(labelTxt);


                                            var found = jQuery.inArray(labelTxt, legendLabelsArr);
                                            if (found >= 0) {
                                                return false;
                                            } else {

                                                legendLabelsArr.push(labelTxt);
                                                return (chartData.datasets[legendItem.datasetIndex].label);
                                            }

                                        },*/

                }
            } ,
            plugins: {
                regressions: {
                    type: 'linear',
                    line: { color: 'blue', width: 3 }
                }
            }

        },
        plugins: [
            ChartRegressions
        ]
    });
    Chart.plugins.register(ChartRegressions);
    return chart;


};

window.drawChartRegressionNew =  function(data, canvas_id, title, chart_type){
    let data_length = data.length;

    let randomColors = randomColorGraph(data_length);

    let labels_arr = [];
    let data_arr = [];
    $(data).each(function (index,value) {
        let name = value.name;
        let sum = value.sum;
        labels_arr.push(name);
        data_arr.push(sum);
    });

    //DIBUJAMOS LA DATA
    var ctx = $('#'+canvas_id);
    chart = new Chart(ctx, {
        type: chart_type,
        data: {

        },
        options: {
            bezierCurve: false,
            scales: {
                yAxes: [
                ],
                xAxes: [{
                    offset: offset,
                    //barThickness: 'auto',  // number (pixels) or 'flex'
                    //maxBarThickness: 'auto', // number (pixels)
                    barPercentage: 0.6,
                    type: "linear",
                    ticks: {
                        source: 'data',
                        stepSize: 1,
                    },
                    // quitar esto para q los puntos se espacien de acuerdo al tiempo pasado
                    distribution: 'series',
                    bounds: 'ticks',
                    scaleLabel: {
                        display: true,
                        labelString: 'Muestra N°',
                        fontSize: 17
                    },

                }],
            },
            annotation: {
                annotations: [{

                }]
            },
            regressions: {
                type: 'linear',
                line: { color: 'blue', width: 3 },
            },
            legend: {
                display:false,
                labels: {
                    fontSize: 14,
                }
            } ,
            plugins: {
                regressions: {
                    type: 'linear',
                    line: { color: 'blue', width: 3 }
                }
            }

        },
        plugins: [
            ChartRegressions
        ]
    });
    Chart.plugins.register(ChartRegressions);
    return chart;


};

window.drawChartRadarNew =  function(data, canvas_id){

    let labels_arr = [];
    $(data).each(function (index, samplingPoint) {
        let name = samplingPoint.name;
        labels_arr.push(name);
    });
    //DIBUJAMOS LA DATA
    var ctx = $('#'+canvas_id);
    chart = new Chart(ctx, {
        type: "radar",
        data: {
            labels: labels_arr,
        },
        options: {
            elements: {
                line: {
                    borderWidth: 3
                }
            },
            scales: {
                yAxes: [
                ],
            },
        }
    });

    return chart;


};

window.randomColorGraph =  function(length){
    //let randomColors = [];
    var graphColors = [];
    var graphOutlines = [];
    var hoverColor = [];
    let i = 0;

    while (i <= length) {
        var randomR = Math.floor((Math.random() * 130) + 100);
        var randomG = Math.floor((Math.random() * 130) + 100);
        var randomB = Math.floor((Math.random() * 130) + 100);

        var graphBackground = "rgb("
            + randomR + ", "
            + randomG + ", "
            + randomB + ")";
        graphColors.push(graphBackground);

        var graphOutline = "rgb("
            + (randomR - 80) + ", "
            + (randomG - 80) + ", "
            + (randomB - 80) + ")";
        graphOutlines.push(graphOutline);

        var hoverColors = "rgb("
            + (randomR + 25) + ", "
            + (randomG + 25) + ", "
            + (randomB + 25) + ")";
        hoverColor.push(hoverColors);

        i++;
    }

    /*
    randomColors.push(graphColors);
    randomColors.push(hoverColor);
    randomColors.push(graphOutlines);
*/
    return randomColors = {
        "graphColors": graphColors,
        "hoverColor": hoverColor,
        "graphOutlines": graphOutlines,
    };

};
window.getStatistics =  function(arr){

    const first = arr => arr[0];

    const last = arr => arr.slice(-1)[0];

    const asc = arr => arr.sort((a, b) => a - b);

    const sum = arr => arr.reduce((a, b) => a + b, 0);

    const mean = arr => sum(arr) / arr.length;

    const min = arr => asc(arr)[0];

    const max = arr => asc(arr).slice(-1)[0];

    const range = arr => max(arr) - min(arr);

    // sample standard deviation
    const std = (arr) => {
        const mu = mean(arr);
        const diffArr = arr.map(a => (a - mu) ** 2);
        return Math.sqrt(sum(diffArr) / (arr.length - 1));
    };

    // sample Coefficient of variation
    const cv = (arr) => {
        const mu = mean(arr);
        const de = std(arr);
        return (de/mu)*100;
    };

    const variance = arr => std(arr)*std(arr);

    // sample average deviation
    const avdv = (arr) => {
        const mu = mean(arr);
        const diffArr = arr.map(a => Math.abs(a - mu));
        return sum(diffArr) / (arr.length );
    };

    // sample standard error
    const se = (arr) => {
        const de = std(arr);
        return de / Math.sqrt( arr.length );
    };

    const quantile = (arr, q) => {
        const sorted = asc(arr);
        const pos = (sorted.length - 1) * q;
        const base = Math.floor(pos);
        const rest = pos - base;
        if (sorted[base + 1] !== undefined) {
            return sorted[base] + rest * (sorted[base + 1] - sorted[base]);
        } else {
            return sorted[base];
        }
    };
    const mode = arr =>
        Object.values(
            arr.reduce((count, e) => {
                if (!(e in count)) {
                    count[e] = [0, e];
                }

                count[e][0]++;
                return count;
            }, {})
        ).reduce((arr, v) => v[0] < arr[0] ? arr : v, [0, null])[1];

    // 95% confidence interval
    const confInt95 = (arr) => {
        const n = arr.length;
        const mean = arr.reduce((a, b) => a + b) / n;
        const stdError = Math.sqrt(arr.reduce((a, b) => a + Math.pow((b - mean), 2), 0) / (n - 1)) / Math.sqrt(n);
        const t = 2.093; // t-value for 95% confidence level and n-1 degrees of freedom
        const lower = mean - t * stdError;
        const upper = mean + t * stdError;
        return [lower.toFixed(2), upper.toFixed(2)];
    };

    // 99% confidence interval
    const confInt99 = (arr) => {
        const n = arr.length;
        const mean = arr.reduce((a, b) => a + b) / n;
        const stdDev = Math.sqrt(arr.map(x => Math.pow(x - mean, 2)).reduce((a, b) => a + b) / (n - 1));
        const t = 3.499; // t-value for 99% confidence level and (n-1) degrees of freedom
        const stdError = stdDev / Math.sqrt(n);
        const lower = mean - t * stdError;
        const upper = mean + t * stdError;
        return [lower.toFixed(2), upper.toFixed(2)];
    };

    const q25 = arr => quantile(arr, .25);

    const q50 = arr => quantile(arr, .50);

    const q75 = arr => quantile(arr, .75);

    const median = arr => q50(arr);

    const calculateSkewness = arr => {
        const n = arr.length;
        const mean = arr.reduce((a, b) => a + b) / n;
        const numerator = arr.reduce((a, b) => a + Math.pow((b - mean), 3), 0);
        const denominator = arr.reduce((a, b) => a + Math.pow((b - mean), 2), 0);
        return numerator / (n * Math.pow(denominator / n, 3 / 2));
    }

    const kurtosis = arr => {
        const n = arr.length;
        const mean = arr.reduce((a, b) => a + b) / n;
        const sampleStdDev = Math.sqrt(arr.reduce((a, b) => a + Math.pow((b - mean), 2), 0) / (n - 1));
        const numerator = arr.reduce((a, b) => a + Math.pow((b - mean), 4), 0) / n;
        const denominator = Math.pow(sampleStdDev, 4);
        return (numerator / denominator) - 3;
    }

    const kolmogorovSmirnov = (data) => {
        const sortedData = data.slice().sort((a, b) => a - b); // Ordenamos los datos
        const n = sortedData.length;
        let dPlus = 0;
        let dMinus = 0;
        for (let i = 0; i < n; i++) {
            const diffPlus = (i + 1) / n - sortedData[i];
            const diffMinus = sortedData[i] - i / n;
            if (diffPlus > dPlus) dPlus = diffPlus;
            if (diffMinus > dMinus) dMinus = diffMinus;
        }
        return Math.max(dPlus, dMinus);
    }

    const calcCriticalKS = (arr, alpha) => {
        const n = arr.length;
        const c = Math.sqrt(-0.5 * Math.log(alpha / 2));
        const d = c / Math.sqrt(n);
        const crit = d + 1.36 / Math.sqrt(n);
        return crit.toFixed(2);
    }

    return statistics = {
        "length": arr.length,
        "range": range(arr) ? range(arr).toFixed(2): null,
        "first": first(arr) ? first(arr).toFixed(2): null,
        "last": last(arr) ? last(arr).toFixed(2): null,
        "min": min(arr) ? min(arr).toFixed(2): null,
        "max": max(arr) ? max(arr).toFixed(2): null,
        "sum": sum(arr) ? sum(arr).toFixed(2): null,
        "mean": mean(arr) ? mean(arr).toFixed(2): null,
        "mode": mode(arr) ? mode(arr).toFixed(2): null,
        "variance": variance(arr) ? variance(arr).toFixed(2): null,
        "std": std(arr) ? std(arr).toFixed(2): null,
        "cv": cv(arr) ? cv(arr).toFixed(2): null,
        "avdv": avdv(arr) ? avdv(arr).toFixed(2): null,
        "se": se(arr) ? se(arr).toFixed(2): null,
        "q25": q25(arr) ? q25(arr).toFixed(2): null,
        "q75": q75(arr) ? q75(arr).toFixed(2): null,
        "median": median(arr) ? median(arr).toFixed(2): null,
        "confInt95": confInt95(arr) ? confInt95(arr) : null,
        "confInt99": confInt99(arr) ? confInt99(arr) : null,
        "skew": calculateSkewness(arr) ? calculateSkewness(arr).toFixed(2) : null,
        "kurtosis": kurtosis(arr) ? kurtosis(arr).toFixed(2) : null,
        "kolmogorovSmirnov": kolmogorovSmirnov(arr) ? kolmogorovSmirnov(arr).toFixed(2) : null,
        "ks10": calcCriticalKS(arr,0.10) ? calcCriticalKS(arr,0.10) : null,
        "ks05": calcCriticalKS(arr,0.05) ? calcCriticalKS(arr,0.05) : null,
        "ks01": calcCriticalKS(arr,0.01) ? calcCriticalKS(arr,0.01) : null,
    };
};
window.randomColorForGraph =  function(length){

    var randomR = Math.floor((Math.random() * 130) + 100);
    var randomG = Math.floor((Math.random() * 130) + 100);
    var randomB = Math.floor((Math.random() * 130) + 100);

    var graphBackground = "rgb("
        + randomR + ", "
        + randomG + ", "
        + randomB + ")";

    var graphOutline = "rgb("
        + (randomR - 80) + ", "
        + (randomG - 80) + ", "
        + (randomB - 80) + ")";

    var hoverColors = "rgb("
        + (randomR + 25) + ", "
        + (randomG + 25) + ", "
        + (randomB + 25) + ")";

    return randomColors = {
        "graphColors": graphBackground,
        "hoverColor": hoverColors,
        "graphOutlines": graphOutline,
    };

};
window.randomColor =  function(){

    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;

};

window.updateChartByType =  function(type){
    //let randomColors = [];
    var graphColors = [];
    var graphOutlines = [];
    var hoverColor = [];
    let i = 0;

    while (i <= length) {
        var randomR = Math.floor((Math.random() * 130) + 100);
        var randomG = Math.floor((Math.random() * 130) + 100);
        var randomB = Math.floor((Math.random() * 130) + 100);

        var graphBackground = "rgb("
            + randomR + ", "
            + randomG + ", "
            + randomB + ")";
        graphColors.push(graphBackground);

        var graphOutline = "rgb("
            + (randomR - 80) + ", "
            + (randomG - 80) + ", "
            + (randomB - 80) + ")";
        graphOutlines.push(graphOutline);

        var hoverColors = "rgb("
            + (randomR + 25) + ", "
            + (randomG + 25) + ", "
            + (randomB + 25) + ")";
        hoverColor.push(hoverColors);

        i++;
    }

    /*
    randomColors.push(graphColors);
    randomColors.push(hoverColor);
    randomColors.push(graphOutlines);
*/
    return randomColors = {
        "graphColors": graphColors,
        "hoverColor": hoverColor,
        "graphOutlines": graphOutlines,
    };

};
//REPORTS
//SELECT LIST
$(document).on('click', '.dropdown-services-list', function (e) {
    e.stopPropagation();
});
//SELECT LIST

window.getMonthName =  function(month){
    month_name = "";

    switch (parseInt(month)) {
        case 1:
            month_name = "enero";
            break;
        case 2:
            month_name = "febrero";
            break;
        case 3:
            month_name = "marzo";
            break;
        case 4:
            month_name = "abril";
            break;
        case 5:
            month_name = "mayo";
            break;
        case 6:
            month_name = "junio";
            break;
        case 7:
            month_name = "julio";
            break;
        case 8:
            month_name = "agosto";
            break;
        case 9:
            month_name = "septiembre";
            break;
        case 10:
            month_name = "octubre";
            break;
        case 11:
            month_name = "noviembre";
            break;
        case 12:
            month_name = "diciembre";
            break;

    }


    return month_name;

};
window.getMonthDescription =  function(months){
    month_description = "";

    let months_number = 0;
    $.each(months, function( index, value ) {
        months_number++;
        let month_name = getMonthName(value);
        if(months_number == 1){
            month_description+=month_name;
        }else{
            month_description+=(", "+month_name);
        }
    });

    if(!months_number){
        month_description="todos los meses";
    }
    return month_description;

};
window.obtenerDatosMuestreoCompararPuntos =  function(deep, parameter_name, parameter, sampling_date_inicio, sampling_date_fin) {


    //Enviamos una solicitud con el ruc de la empresa
    $.ajax({
        type: 'GET',
        //THIS NEEDS TO BE GET
        url: parameter_data_comparisson_route,
        tryCount: 0,
        retryLimit: 3,
        dataType: "json",
        data: {
            parameter_id: parameter,
            deep_id: deep,
            date_initial: sampling_date_inicio,
            date_end: sampling_date_fin,
        },
        success: function success(data) {
            //console.log("-----------------STAGE "+stage_id+"----------------");
            console.log(data);
            let parameter_data_obj = new Object();

            let pointStyle = 'circle';
            let color = $("#radial-color").val();

            let parameter_exists_in_graph = false;
            let dataset_graph_index = 0;

            parameter_data_obj.parameter_name = parameter_name;
            parameter_data_obj.parameter_id = parameter;
            parameter_data_obj.deep_id = deep;
            parameter_data_obj.color = color;
            parameter_data_obj.data = data;

            //addDataToGraph(data.samplingData, pointStyle, color, parameter_name, point_name, graph_type, dataset_graph_index, data.eca, type_graph_data);
            addDataToRadarGraph(data, color, parameter_name);

            //parameters_data_global_array.push(parameter_data_obj);

            //HIDE MODAL
            $("#modalPuntos").modal("hide");
            $("#modalMultiplesPuntos").modal("hide");

            //INPUTS RESET
            $("#sampling_point_id").val("");
            $(".parameter_single").val("");
            $("#deep_id").val("");
            $("#parametersAutocomplete").val("");
            $("#point_name").val("");

            //INPUTS RESET
            $(".leaflet-popup").css("opacity", 0);
        },
        error: function error(data) {
            console.log("-----------------ERROR----------------");
            this.tryCount++;
            console.log("Try: " + this.tryCount + " out of " + this.retryLimit + ".");

            if (this.tryCount <= this.retryLimit) {
                //try again
                $.ajax(this);
                return;
            }

            console.log(data);
            console.log("-----------------ERROR----------------");
        }
    });
};
window.obtenerDatosMuestreo =  function(samplingPoint, deep, parameter_name, parameter, point_name, graph_type, sampling_date_inicio, sampling_date_fin, area_type, scale_type, color) {


    //Enviamos una solicitud con el ruc de la empresa
    $.ajax({
        type: 'GET',
        //THIS NEEDS TO BE GET
        url: parameter_data_route,
        tryCount: 0,
        retryLimit: 3,
        dataType: "json",
        data: {
            sampling_point_id: samplingPoint,
            parameter_id: parameter,
            deep_id: deep,
            date_initial: sampling_date_inicio,
            date_end: sampling_date_fin,
        },
        success: function success(data) {

            if(data.samplingData.length == 0){
                //HIDE MODAL
                $("#modalPuntos").modal("hide");
                $("#modalMultiplesPuntos").modal("hide");

                //INPUTS RESET
                $("#sampling_point_id").val("");
                $("#parameter_id").val("");
                $("#deep_id").val("");
                $("#parametersAutocomplete").val("");
                $("#point_name").val("");

                //INPUTS RESET
                $(".leaflet-popup").css("opacity", 0);
                return;
            }
            let parameter_data_obj = new Object();
            let pointStyle = 'circle';
            if(pointStyleBasin[samplingPoint]){
                pointStyle = pointStyleBasin[samplingPoint];
            }else{
                const randomIndex = Math.floor(Math.random() * pointStylesArr.length); // generate random index within array length
                pointStyle = pointStylesArr[randomIndex]; // get the element at the random index
                pointStylesArr.splice(randomIndex, 1); // remove the element from the array
                pointStyleBasin[samplingPoint] = pointStyle;
                samplePointArr[samplingPoint] = point_name;
            }
            let parameter_exists_in_graph = false;
            let dataset_graph_index = 0;

            parameter_data_obj.point_name = point_name;
            parameter_data_obj.parameter_name = parameter_name;
            parameter_data_obj.sampling_point_id = samplingPoint;
            parameter_data_obj.parameter_id = parameter;
            parameter_data_obj.deep_id = deep;
            parameter_data_obj.point_style = pointStyle;
            parameter_data_obj.eca = data.eca;
            parameter_data_obj.data = data.samplingData;
            parameter_data_obj.graph_type = graph_type;


            //ADDING DATA TO GRAPH
            $.each(parameters_data_global_array, function(index, data) {
                let data_parameter_id = data.parameter_id;
                let data_deep_id = data.deep_id;
                let sampling_point_on_arr = data.sampling_point_id;
                let color_on_arr = data.color;

                console.log("Parameter id: " + parameter + ", data parameter: " + data_parameter_id);
                if (data_parameter_id == parameter && data_deep_id == deep) {
                    console.log("Parametros iguales");
                    parameter_exists_in_graph = true;
                    dataset_graph_index = data.dataset_graph_index;
                    color = color_on_arr;
                }

                /*
                if (sampling_point_on_arr == samplingPoint) {
                    console.log("SP iguales");
                    color = color_on_arr;
                    parameter_data_obj.color = color_on_arr;
                }
                */


            });
            parameter_data_obj.color = color;

            let type_graph_data = 0;
            if (parameters_data_global_array.length == 0) {
                type_graph_data = 0;
                console.log("Primer pararametro en gráfico");
            } else if (parameter_exists_in_graph) {
                type_graph_data = 1;
                console.log("Existe pararametro en gráfico");
            } else {
                type_graph_data = 2;
                console.log("No existe pararametro en gráfico");
                dataset_graph_index = max_dataset_graph_index + 1;
                max_dataset_graph_index = dataset_graph_index;
            }

            //addDataToGraph(data.samplingData, pointStyle, color, parameter_name, point_name, graph_type, dataset_graph_index, data.eca, type_graph_data);

            let eca_blank = {
                allowed_value: null,
                max_value: null,
                min_value: null,
                near_max_value: null,
                near_min_value: null,
                parameter_id: 1
            };
            if(parameter_data_obj.eca){
                if(parameter_data_obj.eca.allowed_value){
                    eca_blank.allowed_value = parameter_data_obj.eca.allowed_value;
                }
                if(parameter_data_obj.eca.max_value){
                    eca_blank.max_value = parameter_data_obj.eca.max_value;
                }
                if(parameter_data_obj.eca.min_value){
                    eca_blank.min_value = parameter_data_obj.eca.min_value;
                }
                if(parameter_data_obj.eca.near_max_value){
                    eca_blank.near_max_value = parameter_data_obj.eca.near_max_value;
                }
                if(parameter_data_obj.eca.near_min_value){
                    eca_blank.near_min_value = parameter_data_obj.eca.near_min_value;
                }
                if(parameter_data_obj.parameter_id){
                    eca_blank.parameter_id = parameter_data_obj.parameter_id;
                }
            }
            addDataToGraph(data.samplingData, pointStyle, color, parameter_name, point_name, graph_type, dataset_graph_index, eca_blank, type_graph_data, area_type, scale_type, deep);
            //addDataToGraph(data.samplingData, pointStyle, color, parameter_name, point_name, graph_type, dataset_graph_index, data.eca, type_graph_data);

            parameter_data_obj.dataset_graph_index = dataset_graph_index;
            parameter_data_obj.type_graph_data = type_graph_data;

            parameters_data_global_array.push(parameter_data_obj);

            //COLOURING POINT
            $(".leaflet-marker-icon[sampling_point=" + samplingPoint + "] .point-marker-span").css("background-color", color);


            //HIDE MODAL
            $("#modalPuntos").modal("hide");
            $("#modalMultiplesPuntos").modal("hide");

            //INPUTS RESET
            $("#sampling_point_id").val("");
            $("#parameter_id").val("");
            $("#deep_id").val("");
            $("#parametersAutocomplete").val("");
            $("#point_name").val("");

            //INPUTS RESET
            $(".leaflet-popup").css("opacity", 0);
        },
        error: function error(data) {
            console.log("-----------------ERROR----------------");
            this.tryCount++;
            console.log("Try: " + this.tryCount + " out of " + this.retryLimit + ".");

            if (this.tryCount <= this.retryLimit) {
                //try again
                $.ajax(this);
                return;
            }

            console.log(data);
            console.log("-----------------ERROR----------------");
        }
    });
}
window.obtenerDatosMuestreoBox =  function(samplingPoint, deep, parameter_name, parameter, point_name, graph_type, sampling_date_inicio, sampling_date_fin) {


    //Enviamos una solicitud con el ruc de la empresa
    $.ajax({
        type: 'GET',
        //THIS NEEDS TO BE GET
        url: parameter_data_route,
        tryCount: 0,
        retryLimit: 3,
        dataType: "json",
        data: {
            sampling_point_id: samplingPoint,
            parameter_id: parameter,
            deep_id: deep,
            date_initial: sampling_date_inicio,
            date_end: sampling_date_fin,
        },
        success: function success(data) {
            if(data.samplingData.length == 0){
                return;
            }
            let parameter_data_obj = new Object();

            let parameter_exists_in_graph = false;
            let dataset_graph_index = 0;

            /*GET COLOR*/
            var parameterOnGlobal = parameters_data_global_array.filter(obj => {
                return obj.parameter_id === parameter && obj.deep_id === deep
            })[0];
            const color = parameterOnGlobal.color;

            parameter_data_obj.point_name = point_name;
            parameter_data_obj.parameter_name = parameter_name;
            parameter_data_obj.sampling_point_id = samplingPoint;
            parameter_data_obj.parameter_id = parameter;
            parameter_data_obj.deep_id = deep;
            parameter_data_obj.eca = data.eca;
            parameter_data_obj.data = data.samplingData;
            parameter_data_obj.color = color;

            /*GETTING BOX DATA*/
            var sample_obj_arr = [];
            $(data.samplingData).each(function(index, sample) {
                var sampleVal = parseFloat(sample.value);
                sample_obj_arr.push(sampleVal);
            });
            let boxData = getBoxPlotStats(sample_obj_arr);
            parameter_data_obj.boxData = boxData;

            sampling_point_box_array.push(parameter_data_obj);

            addDataToBoxGraph(sampling_point_box_array);


            //HIDE MODAL
            $("#modalPuntos").modal("hide");
            $("#modalMultiplesPuntos").modal("hide");

            //INPUTS RESET
            $("#sampling_point_id").val("");
            $("#parameter_id").val("");
            $("#deep_id").val("");
            $("#parametersAutocomplete").val("");
            $("#point_name").val("");

            //INPUTS RESET
            $(".leaflet-popup").css("opacity", 0);
        },
        error: function error(data) {
            console.log("-----------------ERROR----------------");
            this.tryCount++;
            console.log("Try: " + this.tryCount + " out of " + this.retryLimit + ".");

            if (this.tryCount <= this.retryLimit) {
                //try again
                $.ajax(this);
                return;
            }

            console.log(data);
            console.log("-----------------ERROR----------------");
        }
    });
}

window.addDataToGraph =  function(data, pointStyle, color, parameter_name, point_name, graph_type, dataset_graph_index, eca, type_graph_data, area_type, scale_type, deep_id) {
    legendLabelsArr = new Array();

    var sample_obj_arr = [];
    let max_data = 0;
    let min_data = 0;

    $(data).each(function(index, sample) {


        let name = sample.sampling_date;
        name = moment(name).format('MM/DD/Y H:m');
        //console.log(name);
        var sum = sample.value;
        let sampleObj = new Object();

        sampleObj.x = name;
        sampleObj.y = parseFloat(sum);

        sample_obj_arr.push(sampleObj);



        //DEFINING MAX AND MIN VALUE

        //console.log("Valor: "+sum);
        //console.log("Maximo ant: "+max_data);
        //console.log("Minimo ant: "+min_data);
        if (index == 0) {
            max_data = sum;
            min_data = sum;
            //console.log("Index 0: "+index);
        }
        if (parseFloat(sum) > parseFloat(max_data)) {
            max_data = sum;
            //console.log("Mayor: "+sum);
        }
        if (parseFloat(sum) < parseFloat(min_data)) {
            min_data = sum;
            //console.log("Menor: "+sum);
        }

        //console.log("Maximo desp: "+max_data);
        //console.log("Minimo desp: "+min_data);

    });
    //DIBUJAMOS LA DATA
    //let label = parameter_name+" en "+point_name;

    let min_y_graph = min_data;
    let max_y_graph = max_data;

    if (eca["min_value"] !== null) {
        if (parseFloat(eca["min_value"]) < min_data) {
            //min_y_graph = parseFloat(eca["min_value"]);
            //console.log("ECA MIN: " + parseFloat(eca["min_value"]));
        }
    }
    if (eca["max_value"] !== null) {
        if (parseFloat(eca["max_value"]) > max_data) {
            //max_y_graph = parseFloat(eca["max_value"]);
            //console.log("ECA MAX: " + parseFloat(eca["max_value"]));
        }
    }

    if (parseFloat(min_y_graph) < 0) {
        min_y_graph = parseFloat(min_y_graph) * 1.1;
    } else {
        min_y_graph = parseFloat(min_y_graph) * 0.9;
    }
    if (parseFloat(max_y_graph) < 0) {
        max_y_graph = parseFloat(max_y_graph) * 0.9;
    } else {
        max_y_graph = parseFloat(max_y_graph) * 1.1;
    }

    console.log("------ECA------------");
    console.log(eca);
    console.log("------TYPE GRAPH------------");
    console.log(type_graph_data);
    //let label = point_name;
    let label = parameter_name + " en "+ deeps[deep_id];
    //let label = parameter_name+ " en "+point_name;
    let basinsLegend = "";
    let temp = 0;
    $.each( pointStyleBasin, function( key, value ) {
        if(value){
            let samplePointName=  samplePointArr[key];
            let pointStyleSpanish=  pointStyleSpanishArr[value];
            if(temp > 0){
                basinsLegend+=" &nbsp;&nbsp;&nbsp;";
            }
            basinsLegend+=(pointStyleSpanish+" "+samplePointName);
            temp++;
        }
    });

    let scale = 'linear';
    if(scale_type){
        scale = 'logarithmic';
    }
    let yAxesOptions = {
        id: dataset_graph_index,
        scaleLabel: {
            display: true,
            labelString: parameter_name,
            fontSize: 17
        },
        type: scale,
        ticks: {
            suggestedMin: min_y_graph,
            suggestedMax: max_y_graph
        }
    };

    //$chartUserWon.options.scales.xAxes[0].offset = offset;


    if (type_graph_data == 0) {
        $chartUserWon.options.scales.yAxes[dataset_graph_index] = [
            yAxesOptions
        ];
    } else if (type_graph_data == 2) {
        $chartUserWon.options.scales.yAxes.push(yAxesOptions);
    }
    //VALUES
    let fill = false;
    if(area_type){
        fill = 'origin';
    }
    console.log(color);
    $chartUserWon.data.datasets.push({
        yAxisID: dataset_graph_index,
        type: graph_type,
        label: label,
        //lineTension: 0,
        data: sample_obj_arr,
        backgroundColor: transparentColor(color),
        hoverBackgroundColor: color,
        borderColor: color,
        fill: fill,
        borderWidth: 3,
        pointStyle: pointStyle,
        pointRadius: 8
    });

    //ANOTATIONS
    let scaleID = "y-axis-0";
    if (type_graph_data == 2) {
        scaleID = dataset_graph_index;
    }

    console.log("--------DATA GRAPH---------");
    console.log(type_graph_data);

    if (type_graph_data == 0 || type_graph_data == 2 ) {
        //if (false ) {
        console.log("ENTROOOOOOOOOOOOO");
        console.log(eca);

        if (eca["max_value"] !== null) {
            if (parseFloat(eca["max_value"]) < max_y_graph) {

                $chartUserWon.options.annotation.annotations.push({
                    type: 'line',
                    mode: 'horizontal',
                    scaleID: scaleID,
                    value: parseFloat(eca["max_value"]),
                    borderColor: "rgb(255,0,0)",
                    borderWidth: 2,
                    label: {
                        enabled: true,
                        content: "ECA MAX. para " + parameter_name,
                    }
                });
            }
        }
        if (eca["near_max_value"] !== null) {
            if (parseFloat(eca["near_max_value"]) < max_y_graph) {

                $chartUserWon.options.annotation.annotations.push({
                    type: 'line',
                    mode: 'horizontal',
                    scaleID: scaleID,
                    value: parseFloat(eca["near_max_value"]),
                    borderColor: "rgb(210,161,19)",
                    borderWidth: 2,
                    label: {
                        enabled: true,
                        content: "ECA INT. MAX para " + parameter_name,
                    }
                });

            }
        }
        if (eca["min_value"] !== null) {
            if (parseFloat(eca["min_value"]) > min_y_graph) {
                $chartUserWon.options.annotation.annotations.push({
                    type: 'line',
                    mode: 'horizontal',
                    scaleID: scaleID,
                    value: parseFloat(eca["min_value"]),
                    borderColor: "rgb(255,0,0)",
                    borderWidth: 2,
                    label: {
                        enabled: true,
                        content: "ECA MIX. para " + parameter_name,
                    }
                });
            }
        }
        if (eca["near_min_value"] !== null) {
            if (parseFloat(eca["near_min_value"]) > min_y_graph) {
                $chartUserWon.options.annotation.annotations.push({
                    type: 'line',
                    mode: 'horizontal',
                    scaleID: scaleID,
                    value: parseFloat(eca["near_min_value"]),
                    borderColor: "rgb(210,161,19)",
                    borderWidth: 2,
                    label: {
                        enabled: true,
                        content: "ECA INT. MIN para " + parameter_name,
                    }
                });
            }
        }
    }


    //document.getElementById('chartjsLegend').innerHTML = $chartUserWon.generateLegend();
    $chartUserWon.update();


    document.getElementById('chartjsLegend').innerHTML = $chartUserWon.generateLegend();
    $('.chartjsLegend').append(basinsLegend);

    return;

}

window.addDataToRadarGraph =  function(data, color, parameter_name, graph_type) {


    let labels_arr = [];
    let data_arr = [];
    $(data).each(function(index, sample) {
        let sampling_point = sample.id;
        let name = sample.name;
        var sum = sample.mean;


        /*FILTRO*/
        if(jQuery.inArray(sampling_point.toString(), sampling_point_filtered_array) !== -1){
            console.log("sp: "+sampling_point+" in array ");
            labels_arr.push(name);
            data_arr.push(sum);
        }
        /*FILTRO*/
        /*
                    labels_arr.push(name);
                    data_arr.push(sum);*/
        //$chartUserWon.data.labels.push(name);

    });
    console.log(data);
    console.log(data_arr);

    let label = parameter_name;

    //DIBUJAMOS LA DATA
    var ctx = $('#samplings_canvas_comparisson');
    $charComparisson = new Chart(ctx, {
        type: "radar",
        data: {
            labels: labels_arr,
            datasets: [{
                label: "Valor promedio de "+label+" en el tiempo especificado",
                lineTension: 0,
                data: data_arr,
                backgroundColor: color,
                hoverBackgroundColor: color,
                borderColor: color,
                fill: false,
                borderWidth: 3
            }]
        },
        options: {
            elements: {
                line: {
                    borderWidth: 3
                }
            },

        }
    });


}

window.addDataToBoxGraph =  function(sampling_point_box_array) {

    let parametersArray = [];
    let mins_box = [];
    let maxs_box = [];
    $(sampling_point_box_array).each(function(index, sampleInfo) {
        /*min max*/
        let min = parseFloat(sampleInfo.boxData["min"]) ;
        let max = parseFloat(sampleInfo.boxData["max"]);

        if (typeof parametersArray[sampleInfo.parameter_id] !== 'undefined') {
            parametersArray[sampleInfo.parameter_id].push(sampleInfo);
            if(min  < mins_box[sampleInfo.parameter_id]){
                mins_box[sampleInfo.parameter_id] = min;
            }
            if(max  > maxs_box[sampleInfo.parameter_id]){
                maxs_box[sampleInfo.parameter_id] = max;
            }
        }else{
            parametersArray[sampleInfo.parameter_id] = [];
            parametersArray[sampleInfo.parameter_id].push(sampleInfo);
            //set min and max
            mins_box[sampleInfo.parameter_id] = [];
            maxs_box[sampleInfo.parameter_id] = [];
            mins_box[sampleInfo.parameter_id].push(min);
            maxs_box[sampleInfo.parameter_id].push(max);
        }
    });


    $(".boxes-wrapp").html("");
    $(".samplings_canvas_regression_wrapp").html("");
    $(".regresion-formulas").html("");

    console.log("aaaaaaaaaaaaaaaaaaaaaaaaaaa");
    console.log(parametersArray);

    $(parametersArray).each(function(index, sampleInfoPerParameter) {
        console.log("bbbbbbbbbbb");
        console.log(sampleInfoPerParameter);
        if (sampleInfoPerParameter) {
            console.log("entro");

            let min_y_graph = parseFloat(mins_box[index]);
            let max_y_graph = parseFloat(maxs_box[index]);

            if (parseFloat(min_y_graph) < 0) {
                min_y_graph = parseFloat(min_y_graph) * 1.1;
            } else {
                min_y_graph = parseFloat(min_y_graph) * 0.9;
            }
            if (parseFloat(max_y_graph) < 0) {
                max_y_graph = parseFloat(max_y_graph) * 0.9;
            } else {
                max_y_graph = parseFloat(max_y_graph) * 1.1;
            }

            /*CONFIGURATION*/
            let labels = [];
            let datasets = [];
            let data = [];
            let ecaAnnotarions = [];
            let labelParam = null;
            let color = null;
            let scaleID = "y-axis-0";

            $boxCanvas = "<canvas id='samplings_canvas_box"+index+"' class='canvas-report'></canvas>";
            $regressionCanvas = "<canvas id='samplings_canvas_regression"+index+"' class='canvas-report'></canvas>";
            $(".boxes-wrapp").append($boxCanvas);
            $(".samplings_canvas_regression_wrapp").append($regressionCanvas);


            /*REGRESSION*/
            let regressionDatasets = [];

            var ctx = $('#samplings_canvas_regression'+index);
            let chart = new Chart(ctx, {
                type: "scatter",
                data: {
                    labels: [],
                    datasets: []
                },
                options: {
                    title: {
                        display: true,
                        text: 'Chart.js Box Plot Chart',
                    },
                    bezierCurve: false,
                    scales: {
                        yAxes: [
                        ],
                        xAxes: [{
                            offset: offset,
                            //barThickness: 'auto',  // number (pixels) or 'flex'
                            //maxBarThickness: 'auto', // number (pixels)
                            barPercentage: 0.6,
                            type: "linear",
                            ticks: {
                                source: 'data',
                                stepSize: 1,
                            },
                            // quitar esto para q los puntos se espacien de acuerdo al tiempo pasado
                            distribution: 'series',
                            bounds: 'ticks',
                            scaleLabel: {
                                display: true,
                                labelString: 'Muestra N°',
                                fontSize: 17
                            },

                        }],
                    },
                    annotation: {
                        annotations: [{

                        }]
                    },
                    regressions: {
                        type: 'linear',
                        line: { color: 'blue', width: 3 },
                    },
                    legend: {
                        display:false
                    },
                    plugins: {
                        regressions: {
                            type: 'linear',
                            line: { color: 'blue', width: 3 }
                        }
                    }

                },
                plugins: [
                    ChartRegressions
                ]
            });
            /*REGRESSION*/

            console.log(sampleInfoPerParameter);
            $(sampleInfoPerParameter).each(function(index, sampleInfo) {
                labelParam = sampleInfo.parameter_name;
                color = sampleInfo.color;
                let label = sampleInfo.point_name + " en "+ deeps[sampleInfo.deep_id];
                let boxData =
                    {
                        max: sampleInfo.boxData["upperWhisker"],
                        median: sampleInfo.boxData["median"],
                        min: sampleInfo.boxData["lowerWhisker"],
                        outliers: sampleInfo.boxData["outliers"],
                        q1: sampleInfo.boxData["q1"],
                        q3: sampleInfo.boxData["q3"],
                        whiskerMax: sampleInfo.boxData["upperWhisker"],
                        whiskerMin: sampleInfo.boxData["lowerWhisker"]
                    };

                if (sampleInfo.eca["min_value"] !== null) {
                    if (parseFloat(sampleInfo.eca["min_value"]) > min_y_graph) {
                        ecaAnnotarions.push({
                            type: 'line',
                            mode: 'horizontal',
                            scaleID: scaleID,
                            value: parseFloat(sampleInfo.eca["min_value"]),
                            borderColor: "rgb(255,0,0)",
                            borderWidth: 2,
                            label: {
                                enabled: true,
                                content: "Min.",
                            }
                        });
                    }
                }
                if (sampleInfo.eca["max_value"] !== null) {
                    if (parseFloat(sampleInfo.eca["max_value"]) < max_y_graph) {
                        ecaAnnotarions.push({
                            type: 'line',
                            mode: 'horizontal',
                            scaleID: scaleID,
                            value: parseFloat(sampleInfo.eca["max_value"]),
                            borderColor: "rgb(255,0,0)",
                            borderWidth: 2,
                            label: {
                                enabled: true,
                                content: "Máx.",
                            }
                        });
                    }
                }
                if (sampleInfo.eca["near_min_value"] !== null) {
                    if (parseFloat(sampleInfo.eca["near_min_value"]) > min_y_graph) {
                        ecaAnnotarions.push({
                            type: 'line',
                            mode: 'horizontal',
                            scaleID: scaleID,
                            value: parseFloat(sampleInfo.eca["near_min_value"]),
                            borderColor: "rgb(210,161,19)",
                            borderWidth: 2,
                            label: {
                                enabled: true,
                                content: "Int. min.",
                            }
                        });
                    }
                }
                if (sampleInfo.eca["near_max_value"] !== null) {
                    if (parseFloat(sampleInfo.eca["near_max_value"]) < max_y_graph) {
                        ecaAnnotarions.push({
                            type: 'line',
                            mode: 'horizontal',
                            scaleID: scaleID,
                            value: parseFloat(sampleInfo.eca["near_max_value"]),
                            borderColor: "rgb(210,161,19)",
                            borderWidth: 2,
                            label: {
                                enabled: true,
                                content: "Int. máx.",
                            }
                        });
                    }
                }

                labels.push(label);
                data.push(boxData);


                /// regression

                var sample_regression_arr = [];
                $(sampleInfo.data).each(function(index, sample) {
                    var sum = sample.value;
                    let sampleObjRegression = new Object();
                    sampleObjRegression.x = index;
                    sampleObjRegression.y = parseFloat(sum);
                    sample_regression_arr.push(sampleObjRegression);

                });
                chart.data.datasets.push({
                    //lineTension: 0,
                    data: sample_regression_arr,
                    pointStyle: pointStyleBasin[sampleInfo.sampling_point_id],
                    hoverBackgroundColor: color,
                    borderColor: color,
                    borderWidth: 3,
                    pointRadius: 6,
                    regressions: {
                        type: ['linear'],
                        line: { color: color, width: 3},
                    }
                });
                chart.options.title.text = labelParam;
                chart.update();

                var meta = ChartRegressions.getDataset(chart, 0);
                console.log("-------------------");
                console.log(label);
                console.log(sample_regression_arr);
                console.log(meta);
                if(meta){
                    $(".regresion-formulas").append("<div class='ecuaciones-wrapp'>Ecuación "+labelParam+" en "+label+": "+ "<b>" +meta.sections[0].result.string+"</b>. R<sup>2</sup>: "+meta.sections[0].result.r2+"</div>");
                }


                let dataset = {
                    label: label,
                    backgroundColor: transparentColor(color),
                    borderColor: "#888",
                    borderWidth: 1,
                    data: [boxData],
                    outlierColor: '#999999',
                    lowerColor: color,
                };
                datasets.push(dataset);


            });
            //DIBUJAMOS LA DATA
            var ctx = $('#samplings_canvas_box'+index);
            $charBox = new Chart(ctx, {
                type: 'boxplot',
                data: {
                    labels: [labelParam],
                    datasets: datasets,
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Chart.js Box Plot Chart',
                    },
                    scales: {
                        xAxes: [],
                        yAxes: [
                            {
                                ticks: {
                                    suggestedMin: min_y_graph,
                                    suggestedMax: max_y_graph
                                }
                            }
                        ]
                    },
                    annotation: {
                        annotations: ecaAnnotarions
                    },
                },
            });






        }
    });


    return;
}

Number.prototype.countDecimals = function () {
    if(Math.floor(this.valueOf()) === this.valueOf()) return 0;
    return this.toString().split(".")[1].length || 0;
}
window.getBoxPlotStats =  function(arr) {
    // Sort the array in ascending order
    arr.sort(function(a, b) {
        return a - b;
    });

    // Calculate the median
    var median;
    if (arr.length % 2 === 0) {
        median = (arr[arr.length/2 - 1] + arr[arr.length/2]) / 2;
    } else {
        median = arr[Math.floor(arr.length/2)];
    }
    // Return the calculated statistics as an object
    let decimals = median.countDecimals();

    // Calculate the first and third quartiles (Q1 and Q3)
    var q1, q3;
    if (arr.length % 4 === 0) {
        q1 = (arr[arr.length/4 - 1] + arr[arr.length/4]) / 2;
        q3 = (arr[arr.length*3/4 - 1] + arr[arr.length*3/4]) / 2;
    } else {
        q1 = arr[Math.floor(arr.length/4)];
        q3 = arr[Math.floor(arr.length*3/4)];
    }

    // Calculate the interquartile range (IQR)
    var iqr = q3 - q1;

    // Calculate the minimum and maximum values, as well as the outliers
    var min = arr[0];
    var max = arr[arr.length - 1];
    var outliers = [];
    for (var i = 0; i < arr.length; i++) {
        if (arr[i] < q1 - 1.5*iqr || arr[i] > q3 + 1.5*iqr) {
            outliers.push(Math.round(arr[i] * 10000) / 10000);
        }
    }

    // Calculate the lower and upper whiskers
    var lowerWhisker = q1 - 1.5*iqr;
    var upperWhisker = q3 + 1.5*iqr;


    return {
        "min": Math.round(min * 10000) / 10000,
        "max": Math.round(max * 10000) / 10000,
        "lowerWhisker": Math.round(lowerWhisker * 10000) / 10000,
        "upperWhisker": Math.round(upperWhisker * 10000) / 10000,
        "median": Math.round(median * 10000) / 10000,
        "q1": Math.round(q1 * 10000) / 10000,
        "q3": Math.round(q3 * 10000) / 10000,
        "outliers": outliers
    };
}

//window.obtenerDatosMuestreoCompararPuntos =  function
window.render_html_to_canvas = function (html, ctx, x, y, width, height) {
    var data = "data:image/svg+xml;charset=utf-8," + '<svg xmlns="http://www.w3.org/2000/svg" width="' + width + '" height="' + height + '">' +
        '<foreignObject width="100%" height="100%">' +
        html_to_xml(html) +
        '</foreignObject>' +
        '</svg>';

    var img = new Image();
    img.onload = function() {
        ctx.drawImage(img, x, y);
    }
    img.src = data;
}

window.html_to_xml = function (html) {
    var doc = document.implementation.createHTMLDocument('');
    doc.write(html);

    // You must manually set the xmlns if you intend to immediately serialize
    // the HTML document to a string as opposed to appending it to a
    // <foreignObject> in the DOM
    doc.documentElement.setAttribute('xmlns', doc.documentElement.namespaceURI);

    // Get well-formed markup
    html = (new XMLSerializer).serializeToString(doc.body);
    return html;
}
