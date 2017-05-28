package kuznetsovatatjana;

public class Kera implements IArvutused{
    double andmed;

    public Kera(double andmed){
        this.andmed = andmed;
    }

    @Override
    public double arvutaPindala() {
        return 4* Math.PI * Math.pow(andmed, 2);
    }

    @Override
    public double arvutaRuumala() {
        return 4/3 * Math.PI * Math.pow(andmed, 3);
    }
}

