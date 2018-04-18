<div class="row">
    <div class="col">
        Hier Gleiswechsel
         <div id="chartgleis">
        </div>
        
    </div>
</div>


<script type="text/javascript">


var columns = [
            ['keine Abgabe', 20, "Steinfeld"],
            ['5', 30, "Steinfeld"],
            ['2', 120, "Steinfeld"],
        ]
var chart = c3.generate({
    bindto: '#chartgleis',
    data: {
        columns: columns,
        type : 'donut'
    },
    donut: {
        title: columns[0][2]
    }
});

</script>
