import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import javax.imageio.ImageIO;
import javax.swing.JFileChooser;
import javax.swing.filechooser.FileNameExtensionFilter;

public class Main {
    public static void main(String[] args) {
        int targetWidth = 800;
        int targetHeight = 600;
        float quality = 0.5f;

        JFileChooser fileChooser = new JFileChooser();
        fileChooser.setDialogTitle("Select an Image File to Compress");
        FileNameExtensionFilter filter = new FileNameExtensionFilter("Image Files", "jpg", "jpeg", "png", "bmp");
        fileChooser.setFileFilter(filter);

        int userSelection = fileChooser.showOpenDialog(null);
        if (userSelection == JFileChooser.APPROVE_OPTION) {
            File inputFile = fileChooser.getSelectedFile();
            String outputPath = inputFile.getParent() + "/compressed_" + inputFile.getName();

            try {
                BufferedImage originalImage = ImageIO.read(inputFile);

                ImageCompressor compressor = new ImageCompressor();
                BufferedImage resizedImage = compressor.resizeImage(originalImage, targetWidth, targetHeight);
                compressor.compressAndSaveImage(resizedImage, outputPath, quality);

                System.out.println("Image compression completed. Saved to " + outputPath);
            } catch (IOException e) {
                e.printStackTrace();
            }
        } else {
            System.out.println("No file selected. Exiting.");
        }
    }
}
