package kuznetsovatatjana;

public class Kuup implements IArvutused {
    double andmed;

    public Kuup(double andmed){
        this.andmed = andmed;
    }

    @Override
    public double arvutaPindala() {
        return 6 * Math.pow(andmed, 2);
    }

    @Override
    public double arvutaRuumala() {
        return Math.pow(andmed, 3);
    }
}