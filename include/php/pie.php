        <!--Modal para mostrar avisos-->
        <div id="modal_aviso" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Aviso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal_texto">
                        
                    </div>
                </div>
            </div>
        </div>
        <!--Finaliza modal para mostrar avisos-->
    </div>
    <!--Finaliza div de contenido-->

    <!--  Scripts-->
    <script type="text/javascript" src="<?=$raizJS?>/jquery-3.4.1/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="<?=$raizTemplate?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=$raizJS?>/dataTables/js/jquery.dataTables.min.js"></script>
    <!--  Script propio-->
    <script type="text/javascript" src="<?=$raizJS?>/<?=$scriptPropio?>"></script>
    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
</body>
</html>