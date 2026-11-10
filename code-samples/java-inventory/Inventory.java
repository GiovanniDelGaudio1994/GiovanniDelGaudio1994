import java.util.HashMap;
import java.util.Map;
import java.util.Optional;

/**
 * Independent portfolio example: in-memory inventory with explicit validation.
 * No connection to the private GestioneFarmacia project.
 */
public final class Inventory {
    public record Item(String sku, String name, int quantity) {
        public Item {
            if (sku == null || sku.isBlank()) throw new IllegalArgumentException("SKU required");
            if (name == null || name.isBlank()) throw new IllegalArgumentException("Name required");
            if (quantity < 0) throw new IllegalArgumentException("Negative quantity");
        }
    }

    private final Map<String, Item> items = new HashMap<>();

    public void add(Item item) {
        if (items.putIfAbsent(item.sku(), item) != null) {
            throw new IllegalArgumentException("Duplicate SKU");
        }
    }

    public Optional<Item> find(String sku) {
        return Optional.ofNullable(items.get(sku));
    }

    public void changeStock(String sku, int delta) {
        Item current = find(sku).orElseThrow(() -> new IllegalArgumentException("Unknown SKU"));
        long updated = (long) current.quantity() + delta;
        if (updated < 0 || updated > Integer.MAX_VALUE) {
            throw new IllegalArgumentException("Invalid stock change");
        }
        items.put(sku, new Item(current.sku(), current.name(), (int) updated));
    }

    public int totalUnits() {
        return items.values().stream().mapToInt(Item::quantity).sum();
    }
}
