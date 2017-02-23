$.widget("rbbt.cytoscape_tool", {

    options: {

        //{{{ OPTIONS

        // where you have the Cytoscape Web SWF
        swfPath: "/swf/CytoscapeWeb",
        flashInstallerPath: "/swf/playerProductInstall",

        // Network
        knowledge_base: undefined,
        entities: {},
        databases: [],

        // Interactions
        node_click: function(event){},
        edge_click: function(event){},
        menu_items: [],

        points: undefined,
        init: false,
        entity_options: {
            organism: "Hsa/feb2014"
        },

        // Aesthetics
        aesthetics: {nodes:{}, edges:{}},

        visualStyle:{
            nodes:{

                shape:{
                    defaultValue: "RECTANGLE", passthroughMapper: { attrName: 'shape' }
                },

                size:{
                    defaultValue: 25,
                    continuousMapper: {
                        attrName: 'size',
                        minValue: 30,
                        maxValue: 90,
                    }
                },

                opacity:{
                    defaultValue: 0.7,
                    continuousMapper: {
                        attrName: 'opacity',
                        minValue: 0.1,
                        maxValue: 1
                    }
                },
                borderWidth:{
                    defaultValue: 1,
                    continuousMapper: {
                        attrName: 'borderWidth',
                        minValue: 1,
                        maxValue: 10
                    }
                },

                borderColor: {
                    defaultValue: "#555555", passthroughMapper: { attrName: 'borderColor' }
                },

                color: {
                    defaultValue: "#f5f5f5", passthroughMapper: { attrName: 'color' }
                },

            },
            edges:{

                weight:{
                    defaultValue: 3, passthroughMapper: { attrName: 'weight' }
                },

                width:{
                    defaultValue: 3,
                    continuousMapper: {
                        attrName: 'width',
                        minValue: 1,
                        maxValue: 10
                    }
                },
                opacity:{
                    defaultValue: 0.3,
                    continuousMapper: {
                        attrName: 'opacity',
                        minValue: 0.2,
                        maxValue: 1
                    }
                },
                color: {
                    defaultValue: "#999", passthroughMapper: { attrName: 'color' }
                },
            },
        }
    },

    //{{{ MISC FUNCTIONS

    get_options: function(){
        return(this.options);
    },

    add_context_menu_item: function(text, elem, func){
        this.options.menu_items.push({text:text, elem:elem, func:func})
    },

    _update_events: function(){
        var vis = this._vis()
        var tool = this;
        vis.ready(function(){
            tool._process_aesthetics();
            if (tool.options.init == false){
                vis.removeListener("click", "nodes")
                vis.removeListener("click", "edges")
                vis.addListener("click", "nodes", function(event) {
                    tool.options.node_click(event);
                    return false;
                })
                .addListener("click", "edges", function(event) {
                    tool.options.edge_click(event);
                    return false;
                })
                tool.options.init = true;
            }

            for (i in this.options.menu_items){
                var menu_item = this.options.menu_items[i]
                vis.addContextMenuItem(menu_item.text, menu_item.elem, menu_item.func);
            }
        })
    },

    _vis: function() {
        return this.options.vis;
    },

    vis: function(){ return this._vis() },

    // CREATE

    _create: function() {
        this.element.addClass('cytoscape_tool_init')
        this.element.find('.window');
        var div_id = this.element.find('.window').attr('id')
        this.options.idToken = div_id;
        var vis = this.options.vis = new org.cytoscapeweb.Visualization(div_id, this.options);
        this.options.init = false

        var tool = this;
    },

    // CORE FUNCTIONS

    _get_network: function(databases, complete){
        var url = '/knowledge_base/network'
        var data = $.extend({}, {
            knowledge_base: this.options.knowledge_base,
            entities: JSON.stringify(this.options.entities),
            databases: this.options.databases,
            namespace: this.options.namespace,
            _format: 'cytoscape'
        });

        return get_ajax({method: 'POST', url: url, data: data, async: false}, complete);
    },

    //{{{ DRAW

    draw: function(){
        var tool = this;

        if (this.options.network === undefined){
            this._get_network(this.options.databases, function(network){
                tool.options.init = false
                tool.options.network = network
                tool._update_network()
            });
        }else{
            this._update_network();
        }
    },

    _update_network: function(){
        var config = {network: this.options.network, visualStyle: this.options.visualStyle}

        if (undefined !== this.options.points){
            var points = array_values(this.options.points);
            config.layout = {name:"Preset", options:{fitToScreen: true, points: points}}
        }

        this._vis().draw(config)
        this._update_events()
    },

    set_points: function(points){
        this.options.points = points
    },


    // ENTITY FUNCTIONS

    _all_entities: function(){
        var result = [];
        var entities = this.options.entities;
        for (var type in entities){
            result = result.concat(entities[type]);
        }
        return result;
    },

    _get_neighbours: function(database, entities, complete){
        var data = $.extend({ },
                            this.options.entity_options,
                            {
                                //entities: JSON.stringify(entities),
                                collection: JSON.stringify(entities),
                                namespace: this.options.namespace,
                                _format: 'json'
                            })

                            //var url = ['/knowledge_base', this.options.knowledge_base, database, 'entity_collection_neighbours'].join("/")
                            var url = ['/knowledge_base', this.options.knowledge_base, database, 'collection_neighbours'].join("/");

                            return get_ajax({method: 'POST', url: url, data: data, async: false}, complete);
    },


    select_entities: function(entities){
        var vis = this._vis();
        var nodes = vis.nodes();

        var found = []
        $.each(entities, function(){found[this] = true})
        for (i in nodes){
            var node = nodes[i];
            if (found[node.data.id]){
                node.data.color = 'red';
            }else{
                node.data.color = null;
            }
        }
        vis.updateData(nodes);
    },

    add_entities: function(type, entities){
        if (undefined === this.options.entities[type]){
            this.options.entities[type] = $.unique(entities);
        }else{
            this.options.entities[type] = $.unique(
                this.options.entities[type].concat(entities))
                this.options.entities[type] = $.unique(this.options.entities[type]);
        }
        this.options.network = undefined;
    },

    add_neighbours: function(database){
        var tool = this
        this._get_neighbours(database, this.options.entities, function(info){
          for (type in info){
            var entities = info[type]
            tool.add_entities(type, entities)
          }
          this.options.network = undefined;
          this.draw()
        })
    },

    remove_entities: function(type, entities){
        this.options.network = undefined
        if (undefined !== this.options.entities[type]){
            var current_list = this.options.entities[type]
            var new_list = [];
            for (i in current_list){
                var entity = current_list[i];
                if ($.inArray(entity, entities) == -1){
                    new_list.push(entity)
                }
            }
            this.options.entities[type] = new_list
        }
    },

    add_edges: function(database){
        this.options.network = undefined
        this.options.databases.push(database);
        this.options.databases = $.unique(this.options.databases);
    },

    set_edges: function(databases){
        this.options.network = undefined
        this.options.databases = databases.join("|");
    },

    //{{{ ASCETICS
    _elem_feature: function(elem, feature){

        if(undefined === feature){
            return elem.data.id
        }

        if(typeof feature == 'string' ){
            if (undefined !== elem.data[feature]){
                return elem.data[feature];
            }
            if (null !== elem.data.info && undefined !== elem.data.info && undefined !== elem.data.info[feature]){
                return elem.data.info[feature];
            }
            return undefined
        }

        if(typeof feature == 'function' ) return feature(elem)

            return undefined
    },

    _map: function(elem_type, aesthetic, map, feature){
        var vis = this._vis();
        if (elem_type == 'nodes'){
            var elems = vis.nodes();
        }else{
            var elems = vis.edges();
        }

        var updated_elems = []
        for (i in elems){
            var elem = elems[i];
            var code = this._elem_feature(elem, feature)
            if (typeof code == "string"){
                $.each(code.split(";;"), function(i,n){
                    if (undefined !== map[n]){
                        value = map[n];
                        elem.data[aesthetic] = value
                        updated_elems.push(elem)
                    }
                })
            }else{
                if (undefined !== map[code]){
                    value = map[code];
                    elem.data[aesthetic] = value
                    updated_elems.push(elem)
                }
            }

        }
        vis.updateData(updated_elems);
    },

    _map_continuous: function(elem_type, aesthetic, map, feature){
        var vis = this._vis();
        if (elem_type == 'nodes'){
            var elems = vis.nodes();
        }else{
            var elems = vis.edges();
        }
        var tool = this

        if (undefined === map || null === map){
            map = {};
            $.each(elems, function(){
                var elem = this;
                var id = elem.data.id;
                var val = tool._elem_feature(elem, feature);
                map[id] = val;
            })
        }

        var elem_codes = $.map(elems, function(elem){return(tool._elem_feature(elem, feature))});

        if (elem_codes.length == 0){ return }
        var max = 0
        for (entity in map){
            if ($.inArray(entity, elem_codes) > -1){
                var value = parseFloat(map[entity]);
                if (value > max) max = value
            }
        }

        var updated_elems = [];
        for (i in elems){
            var elem = elems[i];
            var code = this._elem_feature(elem, feature)
            if (undefined !== map[code]){
                value = parseFloat(map[code]) / max;
                if (typeof value == 'number' && ! isNaN(value)){
                    elem.data[aesthetic] = value;
                    updated_elems.push(elem);
                }
            }
        }
        vis.updateData(updated_elems);
    },


    _add_aesthetic: function(elem, aesthetic, type, feature, map){
        if (undefined === this.options.aesthetics[elem][aesthetic]) this.options.aesthetics[elem][aesthetic] = []
            this.options.aesthetics[elem][aesthetic].push({type:type, feature:feature, map:map})
    },

    _process_aesthetics: function(){
        for (elem in this.options.aesthetics){
            for (aesthetic in this.options.aesthetics[elem]){
                for (i in this.options.aesthetics[elem][aesthetic]){
                    var info = this.options.aesthetics[elem][aesthetic][i];
                    if(info.type === 'continuous'){
                        this._map_continuous(elem, aesthetic, info.map, info.feature)
                    }else{
                        this._map(elem, aesthetic, info.map, info.feature)
                    }
                }
            }
        }
    },

    list_selected: function(type, selected){
        var vis = this.vis();
        var all_nodes = vis.nodes();
        if (undefined === selected) { selected = vis.selected('nodes'); }

        var selected_type = $.grep(selected, function(e){ return e.data['entity_type'] == type});
        var entities = $.map(selected_type, function(e){ return e.data['id']});
        var annotations = this.options.entity_options;

        var list_name = 'Cytoscape selection'

        var url = '/entity_list/' + type + '/' + list_name
        $.ajax({url: url, cache: false, method:'POST', data:{entities: entities.join("|"), annotations: JSON.stringify(annotations)}, success: function(){
            $('#modal').modal('show_url', url)
        }})
    },

    show_info_old: function(info){

        var table = $('<table>');
        var hrow = $('<tr>');
        table.append($('<thead>').append(hrow));


        var rows = [];
        var keys = [];
        for (key in info){
            keys.push(key);
            hrow.append($('<th>').html(key));

            var value = info[key];
            var parts = value.split(";;");
            for (i in parts){
                var row = rows[i];
                if (undefined === row){ row = (rows[i] = {}) }

                row[key] = parts[i];
            }
        }

        var body = $('<body>')
        for (i in rows){
            var row = rows[i];
            var brow = $('<tr>');

            table.append(brow)

            for (j in keys){
                var key = keys[j];

                brow.append($('<td>').html(row[key]));
            }
        }
        $('#modal').modal('show', table)

    },

    show_info: function(name, database, pair){
        var url = ['/knowledge_base/info', name, database, pair].join("/");
        $('#modal').modal('show_url', url)
    },

    aesthetic: function(elem, aesthetic, map, feature){
        var type = undefined;
        if (undefined === feature){ feature = 'id' }
        if (undefined !== this.options.visualStyle[elem][aesthetic].continuousMapper) type = 'continuous'
            if (undefined !== this.options.visualStyle[elem][aesthetic].discreteMapper) type = 'discrete'
                if (undefined !== this.options.visualStyle[elem][aesthetic].passthroughMapper) type = 'passthrough'

                    this._add_aesthetic(elem, aesthetic, type, feature, map)
                    this.options.network = undefined
    },
});
