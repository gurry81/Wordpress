
    	var IR_widget = function (){
    		this.changes_ir =  {
    			toDelete: [],
    			toEdit: []
    		};

    		this.ir_Editing =  null;
    		this.ir_id_widget = null;
    	}

    		IR_widget.prototype.deleteImageIR = function (ev,$){
    			 var imageId = "#" + ev.target.offsetParent.id;

    			this.changes_ir.toDelete.push(Number(ev.target.offsetParent.id));
    			$(imageId).parent().css({
    				"width": "0",
    				"height": "0"
    			});

    			saveChanges($,ev.target);
				
    		}

    		IR_widget.prototype.showImageData = function(ev,$,data){
    			this.ir_Editing = "#" + ev.target.offsetParent.id;

    			$(getId("image",ev.target)).val(data.url).css("borderColor","orange");
    			$(getId("linkage",ev.target)).val(data.linkage).css("borderColor","orange");

    			$(getId("savewidget",ev.target)).prop("disabled","true");

    		}

    		IR_widget.prototype.saveEdit = function(ev,$){
    			
    			var changes = {
    				id: ir_Editing.replace("#",""),
    				url: $(getId("image",ir_Editing)).val(),
    				linkage: $(getId("linkage",ir_Editing)).val()				
    			}

    			this.changes_ir.toEdit.push(changes);

    			saveChanges($,ev.target);

    			$(getId("image",ir_Editing)).val("").css("borderColor","rgb(221,221,221)");
    			$(getId("linkage",ir_Editing)).val("").css("borderColor","rgb(221,221,221)");
    			$(getId("savewidget",ev.target)).removeProp("disabled");

    		}

    		IR_widget.prototype.saveChanges = function($,element){
    			$(getId("trash",element)).val(JSON.stringify(this.changes_ir));
    		}

    		IR_widget.prototype.getId = function (id, element){

    			if(!this.ir_id_widget){
    			 var id_widget = jQuery(element).parentsUntil(".widget",".widget-inside").parent().attr("id");
    			 this.ir_id_widget = "#widget-" + (id_widget.substr(id_widget.indexOf("_")+1)) + "-";
    			}

	    		 return this.ir_id_widget + id;	 
    		}

    		// instance a object for each widget

    		var ir_instances = Array();
    		var ir_widget = null;
    		set_ir_event_handler();

    		function instance_ir_widget(number){

				ir_instances[number] = new IR_widget();
    		}

    		function set_current_widget(id){
                id = getNumber(id);
				ir_widget = ir_instances[number];

                function getNumber(id){
                    return substr(id.length - 1);
                }
			}

            function set_ir_event_handler(){
                alert("entra");
                jQuey(".widget").filter("[id*='randomimage_wt_sb']").click(function(set_current_widget(this.id)));
            }
