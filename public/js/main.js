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
    function startInterval() {

        //-----------------------------------------------------------------------
        // 2) Send a http request with AJAX http://api.jquery.com/jQuery.ajax/
        //-----------------------------------------------------------------------
        var refreshId = setInterval(function () {
            $('.ls-chats').load("api/server-chats/get/");

            $.ajax({
                url: 'api/server-query/get', //the script to call to get data
                data: "", //you can insert url argumnets here to pass to api.php for example "id=5&parent=6"
                dataType: 'json', //data format
                success: function (data)          //on recieve of reply
                {

                    var hostname = data['hostname'];
                    var version = data['patch'];               //get server version
                    var hostname = data['hostname'];            //get server hostname
                    var gametype = data['gametype'];             //get server gametype 0-bs
                    var map = data['map'];             // or data.map         //Map Encoded into MapID
                    var player_num = data['players_current'];            // Number of Players in Server
                    var player_max = data['players_max'];           // Max Capacity of Server
                    var round_num = data['round'];          // Round Index
                    var round_max = data['numrounds'];          // Round limit per Map
                    //    var timepassed = data[10]  ;         // Time Escaped since Map Loaded
                    //    var actualtimepass = data[11];         // Time passed since Game Started
                    var timeleft = data['timeleft'];       // Round time limit of Round
                    var vict_swat = data['swatwon'];       // Rounds won by SWAT
                    var vict_sus = data['suspectswon'];       // Rounds won by Suspects
                    var swat_score = data['swatscore'];        // Round's SWAT score
                    var sus_score = data['suspectsscore'];     // Round's Suspect score

                    //    var outcome =   data[17] ;           // Outcome of round
                    var nextmap = data['nextmap'];

                    //    var mins,secs,time;
                    //    time = roundtimelimit - timepassed;
                    var mins = parseInt(timeleft/60);
                    var secs = timeleft%60;
                    //    round_num = parseInt(round_num)+1;
                    //map = getMapFromID(map);
                    swat_score = parseInt(swat_score);
                    sus_score = parseInt(sus_score);
                    if(isNaN(swat_score) || isNaN(sus_score))
                    {
                        swat_score='0';
                        sus_score='0';
                    }
                    else (sus_score != swat_score)
                    {
                        if (swat_score > sus_score)
                        {
                            swat_score = '<font color="green">' + swat_score;
                            sus_score = '<font color="B50A0A">' + sus_score;
                        }
                        else if(swat_score < sus_score)
                        {
                            sus_score = '<font color="green">' + sus_score;
                            swat_score = '<font color="B50A0A">' + swat_score;
                        }
                        else
                        {

                        }
                    }
                    $('#ls-swat-score').html(swat_score);
                    $('#ls-swat-wins').html(vict_swat + " wins");
                    $('#ls-suspects-score').html(sus_score);
                    $('#ls-suspects-wins').html(vict_sus + " wins");

                    $('#ls-round').text(round_num + '/' + round_max);
                    $('#ls-time').text(pad(mins)+":"+pad(secs));

                    $('#ls-map-name').text(map);
                    $('#ls-next-map').text("Next : " + getMapByClass(nextmap));
                    $('#ls-player-online').text(player_num);
                    $('#ls-player-limit').text(player_max);


                    var playertable="<thead><tr><th class='col-md-6'>Name</th><th class='col-md-3'>Score</th><th class='text-right col-md-3'>Ping</th></tr></thead><tbody id='ls-player-table-body'></tbody>";

                    var i=0;
                    $.each(data.players,function(){

                        if(data['players'][i]['team']==0)
                        {
                            playertable = playertable + "<tr class=''>";
                            data['players'][i]['name']="<font color='blue'>"+data['players'][i]['name'];
                        }
                        else
                        {
                            playertable = playertable + "<tr class=''>";
                            data['players'][i]['name']="<font color='red'>"+data['players'][i]['name'];
                        }

                        playertable = playertable  +  "          \
                    <td>"+data['players'][i]['name']+"</td>                    \
                    <td>"+data['players'][i]['score']+"</td>                                  \
                    <td class='text-right'>"+data['players'][i]['ping']+"</td>                                  \
                    </tr> ";
                        i++;
                    })
                    $('#ls-player-table').html(playertable);
//                    for(i=0;i<=player_num;i++)
//                    {
//                        $('#liveplayerdata').html(data['players'][0]['name']);
//                    }

                }
            });
        }, 10000);
    }
    startInterval();


        var loading_options = {
            selector: "#loading",
            finishedMsg: "<em>You've reached the end of the round report list.</em>",
            msgText: "<em>Loading the next set of round reports…</em>"
        };

        /**
         * Infinite Scroll for Round Reports
         */
        $('#round-items').infinitescroll({
            loading: loading_options,
            navSelector: ".pagination",
            nextSelector: ".pagination li.active + li a",
            itemSelector: "#round-items .item"
        });
});