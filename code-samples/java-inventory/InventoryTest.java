public final class InventoryTest {
    private static void check(boolean condition, String message) {
        if (!condition) throw new AssertionError(message);
    }

    private static void rejects(Runnable action) {
        try {
            action.run();
            throw new AssertionError("Expected IllegalArgumentException");
        } catch (IllegalArgumentException expected) {
            // Expected validation failure.
        }
    }

    public static void main(String[] args) {
        Inventory inventory = new Inventory();
        inventory.add(new Inventory.Item("A-1", "Notebook", 4));
        check(inventory.find("A-1").orElseThrow().quantity() == 4, "Initial stock");
        inventory.changeStock("A-1", -2);
        check(inventory.totalUnits() == 2, "Stock update");
        rejects(() -> inventory.changeStock("A-1", -3));
        rejects(() -> inventory.add(new Inventory.Item("A-1", "Duplicate", 1)));
        rejects(() -> inventory.add(new Inventory.Item("B-2", "Invalid", -1)));
        System.out.println("Inventory tests passed");
    }
}
