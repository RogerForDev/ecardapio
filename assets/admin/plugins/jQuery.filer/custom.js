$(document).ready(function() {
	$(".file-input").filer({
		limit: 1,
		maxSize: 1,
		extensions: ["png", "jpg"],
		changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Arraste e solte a imagem aqui</h3> <span style="display:inline-block; margin: 15px 0">ou</span></div><a class="jFiler-input-choose-btn blue">Escolher arquivo</a></div></div>',
		showThumbs: true,
		theme: "dragdropbox",
		templates: {
			box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
			item: '<li class="jFiler-item">\
					<div class="jFiler-item-container">\
						<div class="jFiler-item-inner">\
							<div class="jFiler-item-thumb">\
								<div class="jFiler-item-status"></div>\
								<div class="jFiler-item-thumb-overlay">\
									<div class="jFiler-item-info">\
										<div style="display:table-cell;vertical-align: middle;">\
											<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
											<span class="jFiler-item-others">{{fi-size2}}</span>\
										</div>\
									</div>\
								</div>\
								{{fi-image}}\
							</div>\
							<div class="jFiler-item-assets jFiler-row">\
								<ul class="list-inline pull-left">\
									<li>{{fi-progressBar}}</li>\
								</ul>\
								<ul class="list-inline pull-right">\
									<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
								</ul>\
							</div>\
						</div>\
					</div>\
				</li>',
			itemAppend: '<li class="jFiler-item">\
						<div class="jFiler-item-container">\
							<div class="jFiler-item-inner">\
								<div class="jFiler-item-thumb">\
									<div class="jFiler-item-status"></div>\
									<div class="jFiler-item-thumb-overlay">\
										<div class="jFiler-item-info">\
											<div style="display:table-cell;vertical-align: middle;">\
												<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
												<span class="jFiler-item-others">{{fi-size2}}</span>\
											</div>\
										</div>\
									</div>\
									{{fi-image}}\
								</div>\
								<div class="jFiler-item-assets jFiler-row">\
									<ul class="list-inline pull-left">\
										<li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
									</ul>\
									<ul class="list-inline pull-right">\
										<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
									</ul>\
								</div>\
							</div>\
						</div>\
					</li>',
			progressBar: '<div class="bar"></div>',
			itemAppendToEnd: false,
			canvasImage: true,
			removeConfirmation: true,
			_selectors: {
				list: '.jFiler-items-list',
				item: '.jFiler-item',
				progressBar: '.bar',
				remove: '.jFiler-item-trash-action'
			}
		},
		dragDrop: {
			dragEnter: null,
			dragLeave: null,
			drop: null,
			dragContainer: null,
		},
		uploadFile: null,
		files: [],
		addMore: false,
		clipBoardPaste: true,
		excludeName: null,
		beforeRender: null,
		afterRender: null,
		beforeShow: null,
		beforeSelect: null,
		onSelect: null,
		afterShow: null,
		onRemove: null,
		onEmpty: null,
		options: null,
		captions: {
			button: "Escolher arquivo",
			feedback: "Choose files To Upload",
			feedback2: "files were chosen",
			drop: "Arraste arquivos aqui para upload",
			removeConfirmation: "Tem certeza que deseja remover o arquivo?",
			errors: {
				filesLimit: "Somente {{fi-limit}} arquivos são permitidos para o upload.",
				filesType: "Somente Imagens são permitidas para o upload.",
				filesSize: "{{fi-name}} é muito grande! Por favor selecione um arquivo com menos de {{fi-maxSize}} MB.",
				filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
			}
		}
	});
});