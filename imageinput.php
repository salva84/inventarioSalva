<?php $highlight = $_SESSION['highlight']; ?>
<label class="form-label" for="image">Imagen</label>
<input class="form-control <?php if (!empty($messages['image'])) echo 'is-invalid'; ?>" id="image" name="image" type="file">
<div class="form-text" id="file_input_help">PNG, SVG, JPG, JPEG (MAX: 1000x1000px).</div>
<div class="invalid-feedback"><?php echo $messages['image'] ?></div>  
<?php if (isset($row['image'])) { ?><input type="hidden" name="oldimage" value="<?php echo $row['image']; ?>"><?php } ?>