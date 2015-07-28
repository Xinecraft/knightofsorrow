/* 
 * The MIT License
 *
 * Copyright 2015 Zishan Ansari.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Make Gauge Function
 * @param {type} target
 * @param {type} value
 * @param {type} max
 * @returns {undefined}
 */
var makeGauge = function(target, value, max){
    var gauge = new Gauge(document.getElementById(target));
    gauge.setOptions({
        lines: 12,
        angle: 0,
        lineWidth: 0.40,
        pointer: {
            length: 0.8,
            strokeWidth: 0.045,
            color: '#005681'
        },
        limitMax: true,
        percentColors: [[0.0, "#a9d70b" ], [0.50, "#f9c802"], [1.0, "#ff0000"]],
        strokeColor: '#EEE',
        generateGradient: true
    });
    gauge.maxValue = Math.max(max, 0.001);
    gauge.animationSpeed = 24;
    gauge.set(Math.min(Math.max(value, 0.001), gauge.maxValue));

};

/**
 '0': 'A-Bomb Nightclub',
 '1': 'Brewer County Courthouse',
 '2': 'Children of Taronne Tenement',
 '3': 'DuPlessis Diamond Center',
 '4': 'Enverstar Power Plant',
 '5': 'Fairfax Residence',
 '6': 'Food Wall Restaurant',
 '7': 'Meat Barn Restaurant',
 '8': 'Mt. Threshold Research Center',
 '9': 'Northside Vending',
 '10': 'Old Granite Hotel',
 '11': 'Qwik Fuel Convenience Store',
 '12': 'Red Library Offices',
 '13': 'Riverside Training Facility',
 '14': 'St. Michael\'s Medical Center',
 '15': 'The Wolcott Projects',
 '16': 'Victory Imports Auto Center',
 '17': '-EXP- Department of Agriculture',
 '18': '-EXP- Drug Lab',
 '19': '-EXP- Fresnal St. Station',
 '20': '-EXP- FunTime Amusements',
 '21': '-EXP- Sellers Street Auditorium',
 '22': '-EXP- Sisters of Mercy Hostel',
 '23': '-EXP- Stetchkov Warehouse',
 */

/**
 * Returns Maps user friendly name given Id.
 *
 * @param id
 * @returns {*}
 */
function getMapById(id)
{
    var map;
    switch (id)
    {
        case '0':
            map = "A-Bomb Nightclub";
            break;
        case '1':
            map = "Brewer County Courthouse";
            break;
        case '2':
            map = "Children of Taronne Tenement";
            break;
        case '3':
            map = "DuPlessis Diamond Center";
            break;
        case '4':
            map = "Enverstar Power Plant";
            break;
        case '5':
            map = "Fairfax Residence";
            break;
        case '6':
            map = "Food Wall Restaurant";
            break;
        case '7':
            map = "Meat Barn Restaurant";
            break;
        case '8':
            map = "Mt. Threshold Research Center";
            break;
        case '9':
            map = "Northside Vending";
            break;
        case '10':
            map = "Old Granite Hotel";
            break;
        case '11':
            map = "Qwik Fuel Convenience Store";
            break;
        case '12':
            map = "Red Library Offices";
            break;
        case '13':
            map = "Riverside Training Facility";
            break;
        case '14':
            map = "St. Michael\'s Medical Center";
            break;
        case '15':
            map = "The Wolcott Projects";
            break;
        case '16':
            map = "Victory Imports Auto Center";
            break;
        case '17':
            map = "-EXP- Department of Agriculture";
            break;
        case '18':
            map = "-EXP- Drug Lab";
            break;
        case '19':
            map = "-EXP- Fresnal St. Station";
            break;
        case '20':
            map = "-EXP- FunTime Amusements";
            break;
        case '21':
            map = "-EXP- Sellers Street Auditorium";
            break;
        case '22':
            map = "-EXP- Sisters of Mercy Hostel";
            break;
        case '23':
            map = "-EXP- Stetchkov Warehouse";
            break;
        default:
            map = "None";
            break;
    }
    return map;
}

/**
 * Get User Friendly Map Name given map class
 *
 * @param str
 * @returns {*}
 */
function getMapByClass(str)
{
    var map;
    switch (str)
    {
        case 'MP-ABomb':
            map = "A-Bomb Nightclub";
            break;
        case 'MP-Courthouse':
            map = "Brewer County Courthouse";
            break;
        case 'MP-Tenement':
            map = "Children of Taronne Tenement";
            break;
        case 'MP-JewelryHeist':
            map = "DuPlessis Diamond Center";
            break;
        case 'MP-PowerPlant':
            map = "Enverstar Power Plant";
            break;
        case "MP-Fairfaxresidence":
            map = "Fairfax Residence";
            break;
        case 'MP-Foodwall':
            map = "Food Wall Restaurant";
            break;
        case 'MP-MeatBarn':
            map = "Meat Barn Restaurant";
            break;
        case 'MP-DNA':
            map = "Mt. Threshold Research Center";
            break;
        case 'MP-Casino':
            map = "Northside Vending";
            break;
        case 'MP-Hotel':
            map = "Old Granite Hotel";
            break;
        case 'MP-ConvenienceStore':
            map = "Qwik Fuel Convenience Store";
            break;
        case 'MP-RedLibrary':
            map = "Red Library Offices";
            break;
        case 'MP-Training':
            map = "Riverside Training Facility";
            break;
        case 'MP-Hospital':
            map = "St. Michael\'s Medical Center";
            break;
        case 'MP-ArmsDeal':
            map = "The Wolcott Projects";
            break;
        case 'MP-AutoGarage':
            map = "Victory Imports Auto Center";
            break;
        case 'MP-Arcade':
            map = "-EXP- Department of Agriculture";
            break;
        case 'MP-HalfwayHouse':
            map = "-EXP- Drug Lab";
            break;
        case 'MP-Backstage':
            map = "-EXP- Fresnal St. Station";
            break;
        case 'MP-Office':
            map = "-EXP- FunTime Amusements";
            break;
        case 'MP-DrugLab':
            map = "-EXP- Sellers Street Auditorium";
            break;
        case 'MP-Subway':
            map = "-EXP- Sisters of Mercy Hostel";
            break;
        case 'MP-Warehouse':
            map = "-EXP- Stetchkov Warehouse";
            break;
        default:
            map = "None";
            break;
    }
    return map;
}

/**
 * Returns that number after prepending 0 if its smaller than 10.
 *
 * @param n
 * @returns {string}
 */
function pad(n) {
    return (n < 10) ? ("0" + n) : n;
}

$(document).ready(function ()
{

    /**
     * Infinite Scroll
     *
     * loading options of infinite scroll.
     * @type {{selector: string, finishedMsg: string, msgText: string}}
     */
        var loading_options = {
            selector: "#loading",
            finishedMsg: "<em>You've reached the end of Internet ;)</em>",
            msgText: "<em>Loading the next set of data…</em>"
        };

    /**
     * Infinite scroll call.
     */
        $('#data-items').infinitescroll({
            loading: loading_options,
            navSelector: ".pagination",
            nextSelector: ".pagination li.active + li a",
            itemSelector: "#data-items .item"
        });

    //Getting individual player data of round when clicked on round players
    $('.getindistats').click(function(){
        var indi_p_id;
        indi_p_id = $(this).data('id');
        $('.getindistats').removeClass('active');
        $(this).addClass('active');
        $('#indiplayerstats').load("/statistics/ajax/round-player/"+indi_p_id);
    });

    //Click and go to round detail even when clicked on <tr> instead of <a>
    $(".roundstabledata tr").click(function(){
        var id;
        id = $(this).data('id');
        window.location= "/statistics/round-reports/detail/"+id;
    });


    /**
     * Activate tooltipster on all .tooltip class elements
     */
    $('.tooltipster').tooltipster({
        contentAsHTML: true,
        animation: 'grow'
    });


    makeGauge('gauge-spm', $('#gauge-spm').data('spm'), 5.00);
    makeGauge('gauge-wlr', $('#gauge-wlr').data('wlr'), 3.56);
    makeGauge('gauge-acr', $('#gauge-acr').data('acr'), 100.00);
    makeGauge('gauge-kdr', $('#gauge-kdr').data('kdr'), 5.00);
    makeGauge('gauge-aar', $('#gauge-aar').data('aar'), 3.56);
    makeGauge('gauge-spt', $('#gauge-spt').data('spt'), 25.00);
});