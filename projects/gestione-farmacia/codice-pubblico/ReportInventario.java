package model;

/** Modello per una riga di report di inventario, dal progetto universitario GestioneFarmacia. */
public class ReportInventario {
    private String farmacoID;
    private String nomeFarmaco;
    private int quantitaDisponibile;
    private double prezzoUnitario;

    public ReportInventario(String farmacoID, String nomeFarmaco, int quantitaDisponibile, double prezzoUnitario) {
        this.farmacoID = farmacoID;
        this.nomeFarmaco = nomeFarmaco;
        this.quantitaDisponibile = quantitaDisponibile;
        this.prezzoUnitario = prezzoUnitario;
    }

    @Override
    public String toString() {
        return "ReportInventario{" +
                "farmacoID='" + farmacoID + '\'' +
                ", nomeFarmaco='" + nomeFarmaco + '\'' +
                ", quantitaDisponibile=" + quantitaDisponibile +
                ", prezzoUnitario=" + prezzoUnitario +
                '}';
    }

    public String getFarmacoID() { return farmacoID; }
    public void setFarmacoID(String farmacoID) { this.farmacoID = farmacoID; }
    public String getNomeFarmaco() { return nomeFarmaco; }
    public void setNomeFarmaco(String nomeFarmaco) { this.nomeFarmaco = nomeFarmaco; }
    public int getQuantitaDisponibile() { return quantitaDisponibile; }
    public void setQuantitaDisponibile(int quantitaDisponibile) { this.quantitaDisponibile = quantitaDisponibile; }
    public double getPrezzoUnitario() { return prezzoUnitario; }
    public void setPrezzoUnitario(double prezzoUnitario) { this.prezzoUnitario = prezzoUnitario; }
}
