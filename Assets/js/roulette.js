/**
 * Get actual rotate of the spinning machine
 * @param obj the spinning machine
 * @returns {number} the rotation
 */
function getRotation(obj) {
    let matrix = obj.css("-webkit-transform") || obj.css("-moz-transform") || obj.css("-ms-transform") || obj.css("-o-transform") || obj.css("transform");
    let angle;
    if (matrix !== 'none') {
        let values = matrix.split('(')[1].split(')')[0].split(',');
        let a = values[0];
        let b = values[1];
        angle = Math.round(Math.atan2(b, a) * (180 / Math.PI));
    } else {
        angle = 0;
    }
    return (angle < 0) ? angle + 360 : angle;
}

/**
 * Get random int between min and max
 * @param min the min value wanted
 * @param max the max value wanted
 * @returns {number} a int between min and max
 */
function getRandomInt(min, max) {
    return Math.floor(Math.random() * Math.floor(max) + min);
}

/**
 * Sleep function for await sleeping
 * @param ms Time to sleep in millisecond
 * @returns Sleeping time
 */
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

/**
 * Change the text in the launching button
 * @param title The big text
 * @param text The little text
 */
function addButtonText(title, text) {
    $('.button-spin-title').remove();
    $('.button-spin-text').remove();
    button.append("text").attr("x", 0).attr("y", -5).attr("text-anchor", "middle").attr("class", "button-spin-title").text(title).style({
        "font-weight": "bold",
        "font-size": "2em"
    });
    button.append("text").attr("x", 0).attr("y", 25).attr("text-anchor", "middle").attr("class", "button-spin-text").text(text).style({
        "font-size": "1.3em"
    });
}

/**
 * Set timer in the little text for the launching button
 * @param time the time to decount in second
 */
async function addTimerButton(time) {
    for (let i = time; i >= 0; i--) {
        $('.button-spin-timer').remove();
        button.append("text").attr("x", 0).attr("y", 50).attr("text-anchor", "middle").attr("class", "button-spin-timer").text(i).style({
            "text-transform": "uppercase",
            "font-size": "1.2em"
        });
        await sleep(1000);
    }
}

/**
 * Return the rotate of the rotation
 * @returns {function(*=): string}
 */
function rotTween() {
    let i = d3.interpolate(oldRotation % 360, rotation);
    return function (t) {
        return "rotate(" + i(t) + ")";
    };
}

/**
 * SHITI CODE FOR SHOWING THE PORTION
 */
let padding, w, h, r, rotation, oldRotation, picked, color, svg, container, vis, spinner, arc, arcs;
padding = {
    top: 20,
    right: 40,
    bottom: 0,
    left: 0
};
w = 700 - padding.left - padding.right;
h = 700 - padding.top - padding.bottom;
r = Math.min( w, h ) / 2;
rotation = 0;
oldRotation = 0;
picked = 100000;
color = d3.scale.category20();
svg = d3.select( '#chart' ).append( "svg" ).data( [ data ] ).attr( "width", w + padding.left + padding.right ).attr( "height", h + padding.top + padding.bottom );
container = svg.append( "g" ).attr( "class", "chartholder" ).attr( "transform", "translate(" + ( w / 2 + padding.left ) + "," + ( h / 2 + padding.top ) + ")" );
vis = container.append( "g" );
spinner = $( ".chartholder g" ).addClass( 'rotate' ).attr( "transform", "rotate(" + getRandomInt( 0, 360 ) + ")" );
let pie = d3.layout.pie().sort( null ).value( function( d ) {
    return 1;
} );
arc = d3.svg.arc().outerRadius( r );
arcs = vis.selectAll( "g.slice" ).data( pie ).enter().append( "g" ).attr( "class", "slice" );
arcs.append( "path" ).attr( "fill", function( d, i ) {
    return data[ i ].color;
} ).attr( "d", function( d ) {
    return arc( d );
} );
arcs.append( "text" ).attr( "transform", function( d ) {
    d.innerRadius = 0;
    d.outerRadius = r;
    d.angle = ( d.startAngle + d.endAngle ) / 2;
    return "rotate(" + ( d.angle * 180 / Math.PI - 90 ) + ")translate(" + ( d.outerRadius - 35 ) + ", 5)";
} ).attr( "text-anchor", "end" ).text( function( d, i ) {
    return data[ i ].label;
} );
svg.append( "g" ).attr( "transform", "translate(" + ( w + padding.left + padding.right - 20 ) + "," + ( ( h / 2 ) + padding.top ) + ")" ).append( "path" ).attr( "d", "M-" + ( r * .15 ) + ",0L0," + ( r * .15 ) + "L0,-" + ( r * .15 ) + "Z" ).style( {
    "fill": "#080c10"
} );
let button = container.append( "g" ).attr( "class", "button" );
button.append( "circle" ).attr( "cx", 0 ).attr( "cy", 0 ).attr( "r", 80 );
/**
 * END OF SHITI CODE
 */


addButtonText( LangPlayTitle, LangPlayText );

button.on("click", spin);
let isSpinning = false;

/**
 * Spining function for spin the function
 */
async function spin() {
    if (!isSpinning) {
        if (spinner.hasClass("rotate")) {
            let rotation = getRotation(spinner) + 0.1;
            oldRotation = rotation;
            spinner.attr("transform", "rotate(" + rotation + ")");
            spinner.removeClass("rotate");
            addButtonText(LangLaunchTitle, LangLaunchText)
        } else {
            isSpinning = true;
            button.on("click", null);
            button.attr("class", "button launched");
            addButtonText(LangLaunchedTitle, LangLaunchedText);
            addTimerButton(10);

            $.get(xhrGetPrice, function (recompense) {
                let portion = 360 / data.length;
                rotation = getRandomInt(5, 20) * 360 + (recompense - 1) * (360 - portion);
                rotation += 90 - Math.round(portion / 2);
                vis.transition().duration(10000).attrTween("transform", rotTween).each("end", function () {
                    oldRotation = rotation;
                });
                setTimeout(function () {
                    Swal.fire({
                        icon: 'success',
                        text: LangGetPrice + "\"" + data[recompense - 1].label + "\"",
                    });
                    setTimeout(function () {
                        window.location.reload(false);
                    }, 500)
                }, 10000);
            });
        }
    }
}